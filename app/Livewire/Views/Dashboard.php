<?php

namespace App\Livewire\Views;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
  #[Title('Dashboard')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.dashboard');
  }
}
