<div class="f">
    <div class="grid grid-cols-3 gap-2" style="max-width: 1200px;">
        @foreach($bottles as $bottle)
            <div class="col mb-4" style="width: 80%; border: 10px solid #ccc; border-radius: 5px;">
                <div style="display: flex; justify-content: center; padding: 30px;">
                    <img src="{{ $bottle->url_image }}" alt="Bottle Image" style="margin: 0 auto;">
                </div>
                <div class="card-body mb-4" style="text-align: center;">
                    <h5 class="card-title text-xl font-bold mb-2">{{ $bottle->name }}</h5>
                    <p class="mb-4">{{ $bottle->description }}</p>
                    <h5 class="mb-4 font-bold">${{ $bottle->price }}</h5>
                    <span class="text-lg" style="font-size: 11px;">SAQ code: {{ $bottle->code_saq }}</span>
                </div>
            </div>
        @endforeach
        <div class="col-span-2">{{ $bottles->links() }}</div>
    </div>
</div>
