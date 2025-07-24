<?php

namespace App\Livewire\Views\Financas\Baixas\Despesas;

use App\Models\DespesaBaixa;
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

  public DespesaBaixa $baixaAtual;
  public Collection $despesas, $bancos;
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
  public function mount(int $id): void
  {
    try {
      $this->baixaAtual = DespesaBaixa::query()->findOrFail($id);
    } catch (ModelNotFoundException $e) {
      $this->redirect(route('404'), true);
    }

    $this->usuario = Auth::user();
    $despesaAtualId = $this->baixaAtual->despesa->id;
    $this->despesas = $this->usuario->despesas()->where('status', true)
      ->orWhere(function ($query) use ($despesaAtualId) {
        $query->where('id', $despesaAtualId)
          ->where('status', false);
      })->get();
    $this->bancos = $this->usuario->bancos;

    $this->baixa['despesa_id'] = $this->baixaAtual->despesa_id;
    $this->baixa['banco_id'] = $this->baixaAtual->banco_id;
    $this->baixa['data_baixa'] = $this->baixaAtual->data_baixa;
    $this->baixa['forma_pagamento'] = $this->baixaAtual->forma_pagamento;
    $this->baixa['valor'] = $this->baixaAtual->valor;
  }

  #[Title('Finanças - Baixas - Despesas - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.baixas.despesas.edicao');
  }

  public function edicao(): void
  {
    $this->validate(
      rules: [
        'baixa.despesa_id' => 'required',
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

    $despesa = $this->baixaAtual->despesa;

    if ($despesa->valor_aberto === 0 && $this->baixaAtual->valor > $despesa->valor) {
      $this->addError('baixa.valor', 'O valor deve ser menor ou igual ao valor em aberto da despesa.');
      return;
    }

    $this->baixaAtual->update($this->baixa);

    $this->success('Baixa editada com sucesso', redirectTo: route('financas.baixas.despesas.listagem'));
  }
}
