<?php

namespace App\Livewire\Views\Financas\Receitas;

use App\Models\Receita;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Edicao extends Component
{
  use Toast;

  public Authenticatable|User $usuario;
  public Receita $receitaAtual;
  public array $receita = [
    'banco_id' => null,
    'categoria_id' => null,
    'descricao' => null,
    'valor' => null,
    'data' => null,
    'observacao' => null,
    'recorrente' => false,
  ];

  public function mount(int $id): void
  {
    $this->usuario = Auth::user();
    try {
      $this->receitaAtual = Receita::query()->findOrFail($id);
      $this->receita['banco_id'] = $this->receitaAtual->banco_id;
      $this->receita['categoria_id'] = $this->receitaAtual->categoria_id;
      $this->receita['valor'] = $this->receitaAtual->valor;
      $this->receita['recorrente'] = $this->receitaAtual->recorrente;
    } catch (ModelNotFoundException $e) {
      $this->redirect(route('404'), true);
    }
  }
  #[Title('Finanças - Receitas - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.receitas.edicao');
  }

  public function edicao(): void
  {
    $rules = [
      'receita.banco_id' => ['required'],
      'receita.categoria_id' => ['required'],
      'receita.descricao' => ['required', 'max:100'],
      'receita.valor' => ['required'],
      'receita.data' => ['required'],
    ];

    $this->validate($rules, [
      'required' => 'O campo é obrigatório.',
      'receita.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.',
    ]);

    $this->receitaAtual->update($this->receita);

    $this->success('Receita editada com sucesso', redirectTo: route('financas.receitas.listagem'));
  }
}
