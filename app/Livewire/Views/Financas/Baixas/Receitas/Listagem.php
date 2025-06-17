<?php

namespace App\Livewire\Views\Financas\Baixas\Receitas;

use App\Models\ReceitaBaixa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast, WithPagination;

  public Authenticatable|User $usuario;
  public ReceitaBaixa $baixaAtual;
  public ?string $pesquisa = null;
  public ?string $data_baixa = null;
  public int $porPagina = 10;

  public bool $modalVisualizacao = false;
  public bool $modalRemocao = false;

  public function mount(): void
  {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Baixas - Receitas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.receitas.listagem', [
      'baixas' => $this->baixas()
    ]);
  }

  public function baixas(): LengthAwarePaginator
  {
    $query = ReceitaBaixa::query()->where('user_id', $this->usuario->id)->with('receita');

    $query->where(function ($q) {
      $q->where('descricao', 'like', "%{$this->pesquisa}%")
        ->orWhere('valor', $this->pesquisa)
        ->orWhere('observacoes', 'like', "%{$this->pesquisa}%");
    });

    if ($this->data_baixa) {
      $datas = str_contains($this->data_baixa, ' até ')
        ? explode(' até ', $this->data_baixa)
        : $this->data_baixa;

      if (is_array($datas)) {
        $query->whereBetween('data_baixa', array_map(fn($d) => Carbon::parse($d)->startOfDay(), $datas));
      } else {
        $query->whereDate('data_baixa', Carbon::parse($datas)->toDateString());
      }
    }

    return $query->paginate($this->porPagina);
  }

  public function resetaFiltros(): void {
    foreach (['pesquisa', 'data_baixa'] as $item) {
      $this->reset($item);
    }
  }

  public function setBaixaAtual(int $baixa_id, string $opcao): void {
    try {
      $this->baixaAtual = ReceitaBaixa::query()->findOrFail($baixa_id);
    } catch (ModelNotFoundException $e) {
      $this->success('A baixa não existe.');
    }

    match ($opcao) {
      'visualizacao' => $this->modalVisualizacao = !$this->modalVisualizacao,
      'remocao' => $this->modalRemocao = !$this->modalRemocao,
    };
  }

  public function removerBaixa(): void {
    $this->baixaAtual->delete();

    $this->success('Baixa removida com sucesso');
    $this->modalRemocao = !$this->modalRemocao;
  }
}
