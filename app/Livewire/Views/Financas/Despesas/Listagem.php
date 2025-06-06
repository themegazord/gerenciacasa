<?php

namespace App\Livewire\Views\Financas\Despesas;

use App\Models\Despesa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast;

  public Authenticatable|User $usuario;
  public Despesa $despesaAtual;
  public ?string $pesquisa = null;
  public ?string $data_vencimento = null;
  public bool $ativo = true;
  public int $porPagina = 10;

  public bool $modalVisualizacao = false;
  public bool $modalRemocao = false;
  public bool $modalRemocaoDespesaPai = false;

  public function mount(): void
  {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Despesas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.despesas.listagem', [
      'despesas' => $this->despesas()
    ]);
  }

  public function updated(string $props, mixed $valor): void
  {
    if (in_array($props, ['pesquisa', 'data_vencimento', 'ativo'])) {
      $this->despesas();
    }
  }

  public function resetaFiltros(): void
  {
    $this->reset('pesquisa');
    $this->reset('data_vencimento');
    $this->reset('ativo');
  }

  public function despesas(): LengthAwarePaginator
  {
    $query = Despesa::query()->where('user_id', $this->usuario->id)->with('banco')->with('categoria');

    if ($this->ativo !== null) {
      $query->where('status', $this->ativo);
    }

    $query->where(function ($q) {
      $q->where('descricao', 'like', "%{$this->pesquisa}%")
        ->orWhere('observacao', 'like', "%{$this->pesquisa}%")
        ->orWhere('valor', $this->pesquisa);
    });

    if ($this->data_vencimento) {
      $datas = str_contains($this->data_vencimento, ' até ')
        ? explode(' até ', $this->data_vencimento)
        : $this->data_vencimento;

      if (is_array($datas)) {
        $query->whereBetween('data_vencimento', array_map(fn($d) => Carbon::parse($d)->startOfDay(), $datas));
      } else {
        $query->whereDate('data_vencimento', Carbon::parse($datas)->toDateString());
      }
    }

    return $query->paginate($this->porPagina);
  }

  public function setDespesaAtual(int $id, string $modal): void {
    try {
      $this->despesaAtual = Despesa::query()->findOrFail($id);
      match ($modal) {
        'visualizacao' => $this->modalVisualizacao = !$this->modalVisualizacao,
        'remocao' => $this->modalRemocao = !$this->modalRemocao,
      };
    } catch (ModelNotFoundException $e) {
      $this->error('Despesa não existe');
    }
  }

    public function removerDespesa(): void
  {
    try {
      if ($this->despesaAtual->recorrente && !$this->despesaAtual->despesa_pai_id) {
        $this->modalRemocaoDespesaPai = !$this->modalRemocaoDespesaPai;
        return;
      }
      $this->despesaAtual->delete();
      $this->success('Despesa removida com sucesso');
      $this->modalRemocao = !$this->modalRemocao;
    } catch (ModelNotFoundException $e) {
      $this->error('Despesa não existe.', redirectTo: route('financas.despesas.listagem'));
    }
  }

  public function removerDespesaPai(bool $decisao): void
  {
    if ($decisao) {
      $this->despesaAtual->delete();
      $this->success('despesa removida com sucesso');
      $this->modalRemocaoDespesaPai = !$this->modalRemocaoDespesaPai;
      $this->modalRemocao = !$this->modalRemocao;
      return;
    }

    foreach($this->despesaAtual->despesas_filhas as $despesa) {
      $despesa->despesa_pai()->dissociate();
      $despesa->forceFill(['recorrente' => false]);
      $despesa->save();
    }
    $this->despesaAtual->delete();

    $this->success('Despesa removida com sucesso');
    $this->modalRemocaoDespesaPai = !$this->modalRemocaoDespesaPai;
    $this->modalRemocao = !$this->modalRemocao;
    return;
  }
}
