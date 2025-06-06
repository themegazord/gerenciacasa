<?php

namespace App\Livewire\Views\Financas\Despesas;

use App\Models\despesa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Cadastro extends Component
{
  use Toast;

  public Authenticatable|User $usuario;
  public array $despesa = [
    'banco_id' => null,
    'categoria_id' => null,
    'descricao' => null,
    'valor' => null,
    'valor_total' => null,
    'valor_aberto' => null,
    'data_vencimento' => null,
    'observacao' => null,
    'recorrente' => false,
  ];
  public ?int $qtd_recorrencia = null;

  public function mount(): void
  {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Despesas - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.despesas.cadastro');
  }

  public function cadastrar(): void
  {
    $rules = [
      'despesa.banco_id' => ['required'],
      'despesa.categoria_id' => ['required'],
      'despesa.descricao' => ['required', 'max:100'],
      'despesa.valor' => ['required'],
      'despesa.data_vencimento' => ['required'],
      'despesa.recorrente' => ['required'],
    ];

    if ($this->despesa['recorrente']) {
      $rules['qtd_recorrencia'] = ['required', 'integer', 'min:1'];
    }

    $this->validate($rules, [
      'required' => 'O campo é obrigatório.',
      'despesa.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.',
      'integer' => 'Informe o número de meses usando números.',
      'qtd_recorrencia.min' => 'Aceitamos o mínimo de 1 mês.',
    ]);

    $despesaPai = $this->usuario->despesas()->save(new despesa($this->despesa));

    if ($this->despesa['recorrente']) {
      $dataVencimentoBase = Carbon::parse($this->despesa['data_vencimento']);
      if ($this->despesa['valor_aberto'] == 0) {
        $this->despesa['valor_aberto'] = $this->despesa['valor'];
      }
      for ($i = 1; $i <= $this->qtd_recorrencia; $i += 1) {
        $novaDataVencimento = (clone $dataVencimentoBase)->addMonths($i);
        $this->usuario->despesas()->save(new despesa([
          ...$this->despesa,
          'data_vencimento' => $novaDataVencimento,
          'despesa_pai_id' => $despesaPai->id
        ]));
      }
    }

    $this->success('Despesa registrada com sucesso', redirectTo: route('financas.despesas.listagem'));
  }
}
