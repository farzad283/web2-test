<!-- ======
base non terminé
a determiner : allure de la carte 
select pour ajouter au cellier?
autres boutons ? 
===== -->

<article class="border border-gold p-2 m-2 flex rounded-lg">

    <div>
        <h1 class="font-bold mb-2">{{ $bottle->name }}</h1>

        <p class="text-sm">{{ $bottle->description }}</p>
        <!-- et ainsi de suite pour les autres attributs de la bouteille -->
        <a href="{{ $bottle->url }}" class="mb-2"><span class="text-sm">Prix SAQ:</span>{{ $bottle->price }}</a>
    </div>


    <div class="flex-col flex justify-end max-w-100">
      
            <!-- <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="absolute left-20 top-30"> -->
        <img src="{{ $bottle->image }}" alt="{{ $bottle->name }}" class="">
        <select class="text-xs mt-2 rounded-lg">
            <option value="">Ajouter</option>
            <option value="">Cellier 1</option>
            <option value="">Cellier 2</option>

        </select>
    </div>
</article>