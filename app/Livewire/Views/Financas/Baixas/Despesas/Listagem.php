<?php

namespace App\Livewire\Views\Financas\Baixas\Despesas;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast, WithPagination;

  public Authenticatable|User $usuario;
  public ?string $pesquisa = null;
  public ?string $data_baixa = null;
  public array $baixas;
  public int $porPagina = 10;


  public function render()
  {
    return view('livewire.views.financas.baixas.despesas.listagem');
  }
}
