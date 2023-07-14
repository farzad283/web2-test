<div class="flex justify-center items-center h-screen">
    <div class="w-full max-w-sm p-4 bg-white shadow-lg rounded-lg">
        @if (session()->has('message'))
            <div class="mb-4 text-green-500">{{ session('message') }}</div>
        @endif

        <form wire:submit.prevent="store">
            @csrf

            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom :</label>
                <input type="text" wire:model="nom" id="nom" class="w-full px-3 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
                @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full px-4 py-2 mt-4 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                Ajouter un cellier
            </button>
        </form>
    </div>
</div>




