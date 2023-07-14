<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $label;
    public $class;

    public function mount($label = 'Envoyer', $class = 'btn btn-primary')
    {
        $this->label = $label;
        $this->class = $class;
    }

    public function handleClick()
    {
        // coder la fonction handleClick
    }

    public function render()
    {
        return view('livewire.button');
    }
}
