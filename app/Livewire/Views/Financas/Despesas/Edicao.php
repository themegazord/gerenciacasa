<?php

namespace App\Livewire\Views\Financas\Despesas;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Edicao extends Component
{
  use Toast;

  public Authenticatable|User $usuario;
  public Despesa $despesaAtual;
  public array $despesa = [
    'banco_id' => null,
    'status' => false,
    'categoria_id' => null,
    'descricao' => null,
    'valor' => null,
    'data_vencimento' => null,
    'observacao' => null,
    'recorrente' => false,
  ];

  public function mount(int $id): void
  {
    try {
      $this->despesaAtual = Despesa::query()->findOrFail($id);
      $this->despesa['banco_id'] = $this->despesaAtual->banco_id;
      $this->despesa['categoria_id'] = $this->despesaAtual->categoria_id;
      $this->despesa['valor'] = $this->despesaAtual->valor;
      $this->despesa['recorrente'] = $this->despesaAtual->recorrente;
      $this->despesa['status'] = $this->despesaAtual->status;
    } catch (ModelNotFoundException $e) {
      $this->redirect(route('404'), true);
    }
  }

  #[Title('Finanças - Despesas - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.despesas.edicao');
  }

  public function edicao(): void
  {
    $rules = [
      'despesa.banco_id' => ['required'],
      'despesa.categoria_id' => ['required'],
      'despesa.descricao' => ['required', 'max:100'],
      'despesa.valor' => ['required'],
      'despesa.data_vencimento' => ['required'],
    ];


    $this->validate($rules, [
      'required' => 'O campo é obrigatório.',
      'despesa.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.',
      'integer' => 'Informe o número de meses usando números.',
    ]);

    $this->despesaAtual->update($this->despesa);

    $this->success('Despesa atualizado com sucesso', redirectTo: route('financas.despesas.listagem'));
  }
}
