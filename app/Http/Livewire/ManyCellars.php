<?php

namespace App\Http\Livewire;

use App\Models\Cellar;
use Livewire\Component;

class ManyCellars extends Component
{
    public $cellars;
    public $search = '';

    protected $listeners = ['searchPerformed'];

    public function mount()
    {
        $this->loadCellars();
    }

    public function loadCellars()
    {
        if (!empty($this->search)) {
            $this->cellars = Cellar::where('name', 'LIKE', '%' . $this->search . '%')->get();
        } else {
            $this->cellars = Cellar::all();
        }
    }

    public function render()
    {
        return view('livewire.many-cellars', ['cellars' => $this->cellars]);
    }

    public function searchPerformed($search)
{
    $this->search = $search;
    $this->loadCellars();
}

}
