<?php

namespace App\Livewire\Views\Financas\Despesas;

use App\Models\Despesa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Listagem extends Component
{
  public Authenticatable|User $usuario;
  public ?string $pesquisa = null;
  public ?string $data_vencimento = null;
  public bool $ativo = true;
  public int $porPagina = 10;

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
}
