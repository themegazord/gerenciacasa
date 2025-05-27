<?php

namespace App\Livewire\Views\Financas\Categorias;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Listagem extends Component
{
  #[Layout('components.layouts.autenticado')]
  #[Title('Finanças - Categorias')]
  public function render()
  {
    return view('livewire.views.financas.categorias.listagem');
  }
}
