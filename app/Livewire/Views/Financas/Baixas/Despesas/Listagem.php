<?php

namespace App\Livewire\Views\Financas\Baixas\Despesas;

use App\Models\DespesaBaixa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Listagem extends Component
{
  use Toast, WithPagination, WithPagination;

  public Authenticatable|User $usuario;
  public ?string $pesquisa = null;
  public ?string $data_baixa = null;
  public int $porPagina = 10;

  public function mount(): void
  {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Baixas - Despesas')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.despesas.listagem', [
      'baixas' => $this->baixas()
    ]);
  }

  public function baixas(): LengthAwarePaginator
  {
    $query = DespesaBaixa::query()->where('user_id', $this->usuario->id)->with('despesa');

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
}
