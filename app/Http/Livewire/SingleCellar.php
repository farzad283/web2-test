<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Cellar;

class SingleCellar extends Component
{
    public $cellarId;
    public $cellar;
    public $count; 

    // Recupère l'id dans le URL de la page directement à l'ouverture
    public function mount($cellar_id)
    {
        $this->cellarId = $cellar_id;
    }
    
    
    public function render()
    {
        $this->cellar = Cellar::with('bottles')->where('id', $this->cellarId)->first();
        

        return view('livewire.single-cellar', ['cellar' => $this->cellar]);
    }
}
