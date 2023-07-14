<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bottle;
use Livewire\WithPagination;

class ManyBottles extends Component
{
    use WithPagination;
    
    public $component = 'bottles';
    public function styles()
    {
        return [
            'css/livewire.css',
        ];
    }
    public function render()
    {

        $bottles = Bottle::orderBy('name')
            ->paginate(9);

        return view('livewire.many-bottles', [
            'bottles' => $bottles,
        ])->layout('layouts.app');
    }

}
