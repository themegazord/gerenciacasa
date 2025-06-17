<?php

namespace App\Livewire\Views\Financas\Baixas\Receitas;

use App\Models\Receita;
use App\Models\ReceitaBaixa;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Edicao extends Component
{
  use Toast;

  public ReceitaBaixa $baixaAtual;
  public Collection $receitas, $bancos;
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

  public function mount(int $id): void
  {
    try {
      $this->baixaAtual = ReceitaBaixa::query()->findOrFail($id);
    } catch (ModelNotFoundException $e) {
      $this->redirect(route('404'), true);
    }

    $this->usuario = Auth::user();
    $this->receitas = $this->usuario->receitas;
    $this->bancos = $this->usuario->bancos;

    $this->baixa['receita_id'] = $this->baixaAtual->receita_id;
    $this->baixa['banco_id'] = $this->baixaAtual->banco_id;
    $this->baixa['data_baixa'] = $this->baixaAtual->data_baixa;
    $this->baixa['forma_pagamento'] = $this->baixaAtual->forma_pagamento;
    $this->baixa['valor'] = $this->baixaAtual->valor;
  }

  #[Title('Finanças - Baixas - Receitas - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.receitas.edicao', [
      'receitas' => $this->receitas,
      'bancos' => $this->bancos
    ]);
  }

  public function edicao(): void
  {
    $this->validate(
      rules: [
        'baixa.receita_id' => 'required',
        'baixa.descricao' => 'required|max:100',
        'baixa.data_baixa' => 'required',
        'baixa.forma_pagamento' => 'required',
        'baixa.banco_id' => 'required',
        'baixa.valor' => 'required'
      ],
      messages: [
        'required' => 'O campo é obrigatório.',
        'baixa.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.'
      ]
    );

    $receita = $this->baixaAtual->receita;

    if ($receita->valor_aberto === 0 && $this->baixaAtual->valor > $receita->valor) {
      $this->addError('baixa.valor', 'O valor deve ser menor ou igual ao valor em aberto da receita.');
      return;
    }

    $this->baixaAtual->update($this->baixa);

    $this->success('Baixa editada com sucesso', redirectTo: route('financas.baixas.receitas.listagem'));
  }
}
