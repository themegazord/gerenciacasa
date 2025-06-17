<?php

namespace App\Livewire\Views\Financas\Baixas\Receitas;

use App\Models\Receita;
use App\Models\ReceitaBaixa;
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

  public Collection $receitas;
  public Authenticatable|User $usuario;
  public array $baixa = [
    'receita_id' => null,
    'descricao' => null,
    'data_baixa' => null,
    'forma_pagamento' => null,
    'valor' => null,
    'banco_id' => null,
    'observacoes' => null,
  ];

  public function mount(): void {
    $this->usuario = Auth::user();
    $this->receitas = $this->usuario->receitas()->where('status', true)->get();
  }

  #[Title('Finanças - Baixas - Receitas - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.receitas.cadastro', [
      'receitas' => $this->receitas
    ]);
  }

  public function cadastrar(): void {
    $this->validate(
      rules: [
        'baixa.receita_id' => 'required',
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

    if (Receita::query()->find($this->baixa['receita_id'])->valor_aberto - $this->baixa['valor'] < 0) {
      $this->addError('baixa.valor', 'O valor deve ser menor ou igual ao valor em aberto da receita.');
      return;
    }

    $baixa = new ReceitaBaixa($this->baixa);

    $this->usuario->receitaBaixas()->save($baixa);

    $this->success('Baixa registrada com sucesso', redirectTo: route('financas.baixas.receitas.listagem'));
  }
}
