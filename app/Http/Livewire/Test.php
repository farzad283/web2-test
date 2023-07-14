<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Test extends Component
{
    public $message = 'Hello, Livewire!';

    public function changeMessage()
    {
        $this->message = 'Livewire is awesome!';
    }

    public function render()
    {
        return view('livewire.test');
    }
}
