<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bottle;

class SingleBottle extends Component
{
    public $bottle;

    public function mount($bottle_id)
    {
        $this->bottle = Bottle::findOrFail($bottle_id);
    }

    public function render()
    {
        return view('livewire.single-bottle');
    }
}
