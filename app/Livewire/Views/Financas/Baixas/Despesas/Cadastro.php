<?php

namespace App\Livewire\Views\Financas\Baixas\Despesas;

use App\Models\Despesa;
use App\Models\DespesaBaixa;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Cadastro extends Component
{
  use Toast;
  public Collection $despesas;
  public Authenticatable|User $usuario;
  public array $baixa = [
    'despesa_id' => null,
    'descricao' => null,
    'data_baixa' => null,
    'forma_pagamento' => null,
    'valor' => null,
    'banco_id' => null,
    'observacoes' => null,
  ];

  public function mount(): void {
    $this->usuario = Auth::user();
    $this->despesas = $this->usuario->despesas()->where('status', true)->get();
  }

  #[Title('Finanças - Baixas - Despesas - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.despesas.cadastro', [
      'despesas' => $this->despesas
    ]);
  }

  public function cadastrar(): void {
    $this->validate(
      rules: [
        'baixa.despesa_id' => 'required',
        'baixa.descricao' => 'required|max:100',
        'baixa.data_baixa' => 'required',
        'baixa.forma_pagamento' => 'required',
        'baixa.banco_id' => 'required',
        'baixa.valor' => 'required'
      ], messages: [
        'required' => 'O campo é obrigatório.',
        'baixa.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.'
      ]
    );

    if (Despesa::query()->find($this->baixa['despesa_id'])->valor_aberto - $this->baixa['valor'] < 0) {
      $this->addError('baixa.valor', 'O valor deve ser menor ou igual ao valor em aberto da despesa.');
      return;
    }

    $baixa = new DespesaBaixa($this->baixa);

    $this->usuario->despesaBaixas()->save($baixa);

    $this->success('Baixa registrada com sucesso', redirectTo: route('financas.baixas.despesas.listagem'));
  }
}
