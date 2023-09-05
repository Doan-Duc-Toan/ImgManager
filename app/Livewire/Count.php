<?php

namespace App\Livewire;

use Livewire\Component;

class Count extends Component
{
    public $count =100;
    public function add(){
        $this->count++;
    }
    public function render()
    {
        return view('livewire.count');
    }
}
