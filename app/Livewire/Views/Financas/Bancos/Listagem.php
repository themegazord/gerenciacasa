<?php

namespace App\Livewire\Views\Financas\Bancos;

use App\Models\Banco;
use Illuminate\Contracts\Database\Query\Builder;
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
  public string $pesquisa = "";
  public ?string $pesquisaTipoBanco = null;
  public int $porPagina = 5;
  public bool $modalVisualizacao = false;
  public bool $modalInativacao = false;
  public bool $consultaAtivo = true;

  #[Title('Financas - Bancos')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.bancos.listagem', [
      'bancos' => $this->bancos()
    ]);
  }

  public function updated(string $props, mixed $valor): void
  {
    if ($props === 'pesquisaTipoBanco') {
      if (empty($valor)) $this->pesquisaTipoBanco = null;
      $this->bancos();
    };

    if ($props === 'consultaAtivo') {
      $this->bancos();
    }
  }


  public function setVisualizacaoBanco(int $banco_id): void
  {
    try {
      $this->setBancoAtual($banco_id);
      $this->modalVisualizacao = true;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco selecionado não existe.');
    }
  }

  public function setInativacaoBanco(int $banco_id): void
  {
    try {
      $this->setBancoAtual($banco_id);
      $this->modalInativacao = true;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco selecionado não existe.');
    }
  }

  public function inativarBanco(): void
  {
    $this->bancoAtual->delete();

    $this->success('Banco inativo com sucesso');
    $this->modalInativacao = !$this->modalInativacao;
  }

  public function bancos(): LengthAwarePaginator
  {
    $query = Banco::query();

    $query->where(function ($q) {
      $q->where('nome', 'like', "%{$this->pesquisa}%")
        ->orWhere('agencia', 'like', "%{$this->pesquisa}%")
        ->orWhere('numero_conta', 'like', "%{$this->pesquisa}%");
    });

    if ($this->pesquisaTipoBanco !== null) {
      $query->where('tipo', $this->pesquisaTipoBanco);
    }

    if (!$this->consultaAtivo) {
      $query->onlyTrashed(); // caso esteja usando SoftDeletes
    }

    return $query->paginate($this->porPagina);
  }

  private function setBancoAtual(int $banco_id): void
  {
    $this->bancoAtual = Banco::query()->findOrFail($banco_id);
  }
}
