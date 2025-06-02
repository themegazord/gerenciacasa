<?php

namespace App\Livewire\Views\Financas\Receitas;

use App\Models\Receita;
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
  use WithPagination, Toast;

  public ?string $pesquisa = null;
  public ?string $data_recebimento = null;
  public int $porPagina = 10;
  public bool $modalVisualizacao = false;
  public Authenticatable|User $usuario;
  public Receita $receitaAtual;

  public function mount(): void
  {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Receitas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.receitas.listagem', [
      'receitas' => $this->receitas(),
    ]);
  }

  public function updated(string $props, mixed $valor): void
  {
    if (in_array($props, ['pesquisa', 'data_recebimento'])) {
      $this->receitas();
    }
  }

  public function resetaFiltros(): void {
    $this->reset('pesquisa');
    $this->reset('data_recebimento');
  }

  public function receitas(): LengthAwarePaginator
  {
    $query = Receita::query()->where('user_id', $this->usuario->id)->with('banco')->with('categoria');

    $query->where(function ($q) {
      $q->where('descricao', 'like', "%{$this->pesquisa}%")
        ->orWhere('observacao', 'like', "%{$this->pesquisa}%")
        ->orWhere('valor', $this->pesquisa);
    });

    if ($this->data_recebimento) {
      $datas = str_contains($this->data_recebimento, ' até ')
        ? explode(' até ', $this->data_recebimento)
        : $this->data_recebimento;

      if (is_array($datas)) {
        $query->whereBetween('data', array_map(fn($d) => Carbon::parse($d)->startOfDay(), $datas));
      } else {
        $query->whereDate('data', Carbon::parse($datas)->toDateString());
      }
    }

    return $query->paginate($this->porPagina);
  }

  public function setReceitaAtual(int $receita_id, string $gatilho): void {
    try {
      $this->receitaAtual = Receita::query()->findOrFail($receita_id);
      match ($gatilho) {
        'visualizacao' => $this->modalVisualizacao = !$this->modalVisualizacao,
      };
    } catch (ModelNotFoundException $e) {
      $this->error('Receita não existe.');
    }

  }
}
