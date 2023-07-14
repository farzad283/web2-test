<?php

namespace App\Services;

use App\Models\Bottle;
use App\Models\Bouteille;
use App\Models\Type;
use App\Models\Country;


use stdClass;
use DOMDocument;




class SAQService
{
    const DUPLICATION = 'duplication';
    const ERREURDB = 'erreurdb';
    const INSERE = 'Nouvelle bouteille insérée';

    private static $_webpage;
    private static $_status;

    /**
     * getProduits
     * @param int $nombre
     * @param int $page
     * @return int
     */
    public function getProduits($nombre = 48, $page)
    {
        $s = curl_init();
        $url = "https://www.saq.com/fr/produits/vin?p=" . $page . "&product_list_limit=" . $nombre . "&product_list_order=name_asc";



        curl_setopt_array($s, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
            CURLOPT_ENCODING => 'gzip, deflate',
            CURLOPT_HTTPHEADER => array(
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                /* Qu'on accepte ce type de contenu pour la réponse, le q est pour la qualité  */
                'Accept-Language: en-US,en;q=0.5',
                /* On veut que la réponse soit en en-US, en(english) générique et préférence de qualité 0.5 */
                'Accept-Encoding: gzip, deflate',
                /* Qu'on accepte ce type d'encodage */
                'Connection: keep-alive',
                /* La connexion TCP doit être maintenu ouverte apres la reponse, afin de pouvoir réutilisé pour des requêtes ultérieures */
                'Upgrade-Insecure-Requests: 1',
                /* MEttre http à https pour les ressources qui supporte https, la valeur 1 indique que le client est prêt à effectuer cette mise à niveau */
            ),
        ));

        self::$_webpage = curl_exec($s); /*On execute les options définies plus haut avec curl_setopt_array */
        self::$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);  /* POur avoir le status le code de statut, pour obtenir  des information sur la requête */
        curl_close($s); /* Fermer la session cURL  */

	
        $doc = new DOMDocument();
        $doc->recover = true; // Va faire de son mieux pour corriger les erreurs, balises mal fermées, attributs manquants, des élément mal placés, etc. 
        $doc->strictErrorChecking = false;
        @$doc->loadHTML(self::$_webpage);
        $elements = $doc->getElementsByTagName('li');
        // $i = 0;

        foreach ($elements as $key => $noeud) {
            if (strpos($noeud->getAttribute('class'), "product-item") !== false) {
                $info = self::recupereInfo($noeud);
                $result = $this->ajouteProduit($info);
                $resultData = [
                    'nom' => $info->nom,
                    'retour' => [
                        'succes' => $result->succes,
                        'raison' => $result->raison,
                    ],
                ];

                $results[] = $resultData;
            }
        }

        return $results;
    }

    private function get_inner_html($node)
    {
        $innerHTML = '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveXML($child);
        }

        return $innerHTML;
    }


    private function nettoyerEspace($chaine)
    {
        return preg_replace('/\s+/', ' ', $chaine);
    }

    private function getTypeID($typeName)
    {
        //Vérification de l'existance du type, s'il n'existe pas, on va le créer, sinon on renvoie la clé. 
        $type = Type::firstOrCreate(['name' => $typeName]);
        return $type->id;
    }

    private function getCountryId($countryName)
    {
        //Vérification de l'existance du pays, s'il n'existe pas, on va le créer, sinon on renvoie la clé. 
        $country = Country::firstOrCreate(['name' => $countryName]);
        return $country->id;
    }
    
    /**
    * @param $string Recoit une chaine 
    * @return string  retourne une chaine de caractère qui contient le millésime
    */

    private function getVintage($string)
    {
        $array = explode(" ", $string);
        $lastElement = end($array);
        if (is_numeric($lastElement)) {
            return $lastElement;
        } else {
            return null;
        }
    }
    

    /**
     * 
     * Cherche dans le html les éléments nécessaires pour créer une instance de bouteille
     * @param $noeud Données à filtrer/récuperer 
     * @return stdClass Objet contenant les informations d'une bouteille.
     **/

    private function recupereInfo($noeud)
    {
        $info = new stdClass(); // Utiliser pour créer un objet vide que nous allons peupler. 
        $images = $noeud->getElementsByTagName("img");

        foreach ($images as $img) {
            $class = $img->getAttribute('class');
            if (strpos($class, 'product-image-photo') !== false) {
                $info->img = $img->getAttribute('src');
                break;
            }
        }
        $a_titre = $noeud->getElementsByTagName("a")->item(0);
        $info->url = $a_titre->getAttribute('href');

        $nom = $noeud->getElementsByTagName("a")->item(1)->textContent;

        $info->nom = self::nettoyerEspace(trim($nom));
        $info->vintage = self::getVintage($info->nom);

        $aElements = $noeud->getElementsByTagName("strong");
        foreach ($aElements as $node) {
            if ($node->getAttribute('class') == 'product product-item-identity-format') {
                $info->desc = new stdClass();
                $info->desc->texte = $node->textContent;
                $info->desc->texte = self::nettoyerEspace($info->desc->texte);
                $aDesc = explode("|", $info->desc->texte); // Type, Format, Pays
                if (count($aDesc) == 3) {

                    $info->desc->type_id = self::getTypeId(trim($aDesc[0]));
                    $info->desc->format = trim($aDesc[1]);
                    $info->desc->country_id = self::getCountryId(trim($aDesc[2]));
                }

                $info->desc->texte = trim($info->desc->texte);
                /* var_dump($info->desc->texte); */
            }
        }

        //Code SAQ
        $aElements = $noeud->getElementsByTagName("div");
        foreach ($aElements as $node) {
            if ($node->getAttribute('class') == 'saq-code') {
                if (preg_match("/\d+/", $node->textContent, $aRes)) {
                    $info->desc->code_SAQ = trim($aRes[0]);
                }
            }
        }

        $aElements = $noeud->getElementsByTagName("span");
        foreach ($aElements as $node) {
            if ($node->getAttribute('class') == 'price') {
                $prix = trim($node->textContent);
                $prix_nettoyer = str_replace("$", "", $prix);
                $prix_point = str_replace(',', ".", $prix_nettoyer);
                $info->prix = floatval($prix_point);
            }
        }
        //var_dump($info);
        return $info;
    }


    /**
     * Ajoute un produit à la base de données.
     *
     * @param $bte Données du produit à ajouter.
     * @return stdClass Objet contenant le statut de l'ajout.
     */
    private function ajouteProduit($bte)
    {
        // cr.ation de l'objet de retour 
        $retour = new stdClass();
        $retour->succes = false;
        $retour->raison = '';

        //vérifier si le produit exsite déjà dans la BD
        $rows = Bottle::where('code_saq', $bte->desc->code_SAQ)->count();


        //Création d'une nouvelle instance de bouteille 
        if ($rows < 1) {
            //attribution des valeurs de la bouteille
            $nouvelleBouteille = new Bottle();
            $nouvelleBouteille->name = $bte->nom;
            $nouvelleBouteille->type_id = $bte->desc->type_id;
            $nouvelleBouteille->image = $bte->img;
            $nouvelleBouteille->code_saq = $bte->desc->code_SAQ;
            $nouvelleBouteille->country_id = $bte->desc->country_id;
            $nouvelleBouteille->description = $bte->desc->texte;
            $nouvelleBouteille->price = $bte->prix;
            $nouvelleBouteille->url_saq = $bte->url;
            $nouvelleBouteille->url_image = $bte->img;
            $nouvelleBouteille->format = $bte->desc->format;
            $nouvelleBouteille->vintage = $bte->vintage;

            try {
                //tentative d'enregistrement, si ça fonctionne un message de succes sera inséré dans l'objet
                $retour->succes = $nouvelleBouteille->save();
                $retour->raison = self::INSERE;
            } catch (\Exception $e) {
                // Sinon, un message d'erreur sera envoyé 
                $retour->succes = false;
                $retour->raison = $e->getMessage();
            }
        } else {
            //Si la bouteille existe déjà on envoie un message de duplication et succes à false.
            $retour->succes = false;
            $retour->raison = self::DUPLICATION;
        }

        return $retour;
    }



    /**
     * Récupère tous les produits de la SAQ.
     *
     * @return array Tableau contenant tous les produits de la SAQ.
     */
    public function fetchProduit()
    {
        $pages = 345;
        $perPage = 24;
        $currentPage = 1;
        $results = [];

        set_time_limit(0); // enleve le temps limite de l'execution du script

        while ($currentPage <= $pages) {
            $pageResults = $this->getProduits($perPage, $currentPage);
            $results = array_merge($results, $pageResults);
            $currentPage++;

            // optionnel, ajout d'un délais entre les itereations pour éviter de surcharger le serveur
            usleep(100000); // Mettre en veille pendant 100 millisecondes (ajuster selon votre préférence)
        }
        return $results;
    }
}
