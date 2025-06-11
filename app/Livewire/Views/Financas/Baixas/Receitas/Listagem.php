<?php

namespace App\Livewire\Views\Financas\Baixas\Receitas;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Listagem extends Component
{
  #[Title('Finanças - Baixas - Receitas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.receitas.listagem');
  }
}
