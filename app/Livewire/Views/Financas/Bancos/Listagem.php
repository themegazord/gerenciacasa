<?php

namespace App\Livewire\Views\Financas\Bancos;

use App\Models\Banco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast, WithPagination;

  public Banco $bancoAtual;
  public LengthAwarePaginator $bancos;
  public string $pesquisa = "";
  public bool $modalVisualizacao = false;
  public bool $modalInativacao = false;
  public bool $consultaAtivo = true;

  #[Title('Financas - Bancos')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.bancos.listagem');
  }

  public function setVisualizacaoBanco(int $banco_id): void {
    try {
      $this->setBancoAtual($banco_id);
      $this->modalVisualizacao = true;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco selecionado não existe.');
    }
  }

  public function setInativacaoBanco(int $banco_id): void {
    try {
      $this->setBancoAtual($banco_id);
      $this->modalInativacao = true;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco selecionado não existe.');
    }
  }

  public function inativarBanco(): void {
    $this->bancoAtual->delete();

    $this->success('Banco inativo com sucesso');
    $this->modalInativacao = !$this->modalInativacao;
  }

  private function setBancoAtual(int $banco_id): void {
    $this->bancoAtual = Banco::query()->findOrFail($banco_id);
  }
}
