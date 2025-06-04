<?php

namespace App\Livewire\Views\Financas\Despesas;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Listagem extends Component
{
  #[Title('Finanças - Despesas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.despesas.listagem');
  }
}
