<?php

namespace App\Livewire\Views\Financas\Bancos;

use App\Models\Banco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast, WithPagination;

  public Banco $bancoAtual;
  public bool $modalVisualizacao = false;

  #[Title('Financas - Bancos')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.bancos.listagem');
  }

  public function setVisualizacaoBanco(int $banco_id): void {
    try {
      $this->bancoAtual = Banco::query()->findOrFail($banco_id);
      $this->modalVisualizacao = true;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco selecionado não existe');
    }
  }
}
