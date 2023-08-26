<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ExamplePage extends Component
{
    #[Layout('layouts.guest-livewire')]
    public function render()
    {
        return view('livewire.example-page');
    }
}
