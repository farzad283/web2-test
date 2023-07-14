<?php

namespace App\Http\Controllers;

use App\Models\Bottle;
use App\Http\Controllers\Controller;
use App\Models\BottleConsumed;
use App\Models\BottleInCellar;
use App\Models\Cellar;
use Illuminate\Http\Request;

class BottleController extends Controller
{


    /**
     * Afficher toutes les bouteilles de la BD
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Aller chercher toutes les bouteilles
        $bottles = Bottle::all();
        return view('bottle.index');
        // return response()->json(['success' => true, 'data' => $bottles])->header('Content-Type', 'application/json');
    }
///////////////////////////////////////////////////////////////////////////////
    /**
     * Rechercher une bouteille dans la BD
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchBottle(Request $request)
    {
        // Aller chercher le nom et le nombre de résultats associés à la requête
        $nom = $request->input('nom');
        $nb_resultat = $request->input('nb_resultat', 10);

        // Trouver les bouteilles correspondantes à l'entrée $nom
        $rows = Bottle::where('name', 'like', '%' . $nom . '%')
            ->limit($nb_resultat)
            ->get(['id', 'name']);

        return response()->json($rows);
    }
/////////////////////////////////////////////////////////////////////////
    /**
     * Ajouter une bouteille non listée à un cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajouterNouvelleBottleCellier(Request $request)
    {
        // Aller chercher l'id de la bouteille et l'id du cellier provenant de la requête.
        $bottleId = $request->input('bottle_id');
        $cellarId = $request->input('cellar_id');

        // Vérifier si le cellier et la bouteille existe
        $cellar = Cellar::findOrFail($cellarId);
        $bottle = Bottle::findOrFail($bottleId);

        // Ajouter la bouteille existante dans le cellier.
        $bottleInCellar = new BottleInCellar([
            'bottle_id' => $bottleId,
            'cellar_id' => $cellarId,
            'quantity' => 1
        ]);
        $result = $bottleInCellar->save();

        return response()->json($result);
    }
///////////////////////////////////////////////////////////////////////
    /**
     * Boire une bouteille d'un cellier (delete)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function boireBottleCellier(Request $request)
    {
        // Get the bottle ID, cellar ID, consumption date, and note from the request
        $bottleId = $request->input('bottle_id');
        $cellarId = $request->input('cellar_id');
        $consumptionDate = $request->input('consumption_date');
        $note = $request->input('note');

        // Add consumed bottle information to the BottleConsumed table
        $bottleConsumed = new BottleConsumed([
            'bottle_id' => $bottleId,
            'cellar_id' => $cellarId,
            'consumption_date' => $consumptionDate,
            'note' => $note
        ]);

        $bottleConsumed->save();

        // Decrease the quantity of bottles in the BottleInCellar table
        $bottleCellier = BottleInCellar::where('bottle_id', $bottleId)
            ->where('cellar_id', $cellarId)
            ->first();

        if ($bottleCellier) {
            $bottleCellier->quantity = $bottleCellier->quantity - 1;
            $bottleCellier->save();
        }

        return response()->json(['success' => true, 'message' => 'Bottle consumed and quantity updated']);
    }
////////////////////////////////////////////////////////////////////////////
    /**
     * Ajouter une bouteille ou mettre à jour une quantité de bouteilles dans un cellier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajouterBottleCellier(Request $request)
    {
        // Aller chercher l'id de la bouteille, l'id du cellier et la nouvelle quantité provenant de la requête.
        $bottleId = $request->input('bottle_id');
        $cellarId = $request->input('cellar_id');
        $newQuantity = $request->input('new_quantity');

        // Voir si la bouteille existe dans le cellier (devrait être vérifier dans LES celliers)
        $bottleInCellar = BottleInCellar::where('bottle_id', $bottleId)
            ->where('cellar_id', $cellarId)
            ->first();

        if ($bottleInCellar) {
            $bottleInCellar->quantity = $newQuantity;
            $bottleInCellar->save();

            return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Bottle not found in the cellar']);
    }

      /**
     * Afficher une bouteille.
     *
     * @param  \App\Models\Bottle  $cellar
     * @return \Illuminate\Http\Response
     */
    public function show(Bottle $bottle)
    {
        return view('bottle.show', ['bottle' => $bottle]);
    }
}

