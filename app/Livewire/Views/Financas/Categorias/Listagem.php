<?php

namespace App\Livewire\Views\Financas\Categorias;

use App\Models\CategoriaFinanca;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use WithPagination, Toast;

  public CategoriaFinanca $categoriaAtual;
  public bool $modalVisualizacao = false;
  public bool $modalAlteracaoStatusCategoria = false;
  public bool $pesquisaAtivo = true;
  public string $pesquisa = "";
  public ?string $pesquisaTipo = null;
  public int $porPagina = 10;

  #[Layout('components.layouts.autenticado')]
  #[Title('Finanças - Categorias')]
  public function render()
  {
    return view('livewire.views.financas.categorias.listagem', [
      'categorias' => $this->categorias()
    ]);
  }

  public function updated(string $props, mixed $valor): void {
    if ($props === 'pesquisaTipo') {
      if ($valor === "") $this->pesquisaTipo = null;
      $this->categorias();
    }

    if ($props === 'pesquisaAtivo') $this->categorias();
  }

  public function categorias(): LengthAwarePaginator {
    $query = CategoriaFinanca::query();

    $query->where(function ($q) {
      $q->where('nome', 'like', "%{$this->pesquisa}%");
    });

    if ($this->pesquisaTipo !== null) {
      $query->where('tipo', $this->pesquisaTipo);
    }

    if (!$this->pesquisaAtivo) {
      $query->onlyTrashed();
    }

    return $query->paginate($this->porPagina);
  }

  public function setCategoriaVisualizacao(int $id): void {
    try {
      $this->categoriaAtual = CategoriaFinanca::query()->withTrashed()->findOrFail($id);
      $this->modalVisualizacao = !$this->modalVisualizacao;
    } catch (ModelNotFoundException $e) {
      $this->warning('Categoria não existe.');
    }
  }

  public function setCategoriaInativacao(int $id): void {
    try {
      $this->categoriaAtual = CategoriaFinanca::query()->withTrashed()->findOrFail($id);
      $this->modalAlteracaoStatusCategoria = !$this->modalAlteracaoStatusCategoria;
    } catch (ModelNotFoundException $e) {
      $this->warning('Categoria não existe.');
    }
  }

  public function alterarStatusCategoria(): void {
    if (!$this->categoriaAtual->trashed()) {
      $this->categoriaAtual->delete();
    } else {
      $this->categoriaAtual->restore();
    }

    $this->success('Status da categoria alterado.');
    $this->modalAlteracaoStatusCategoria = !$this->modalAlteracaoStatusCategoria;
  }
}
