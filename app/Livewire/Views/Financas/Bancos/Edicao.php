<?php

namespace App\Livewire\Views\Financas\Bancos;

use App\Models\Banco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Edicao extends Component
{
  use Toast;

  public Banco $bancoAtual;
  public array $banco = [
    'nome' => null,
    'tipo' => null,
    'saldo_inicial' => null,
    'saldo_atual' => null,
    'agencia' => null,
    'numero_conta' => null,
    'ativo' => true,
    'descricao' => null
  ];

  public function mount(int $id): void
  {
    try {
      $this->bancoAtual = Banco::query()->findOrFail($id);
      $this->banco['tipo'] = $this->bancoAtual->tipo;
      $this->banco['ativo'] = (bool)$this->bancoAtual->ativo;
      $this->banco['saldo_inicial'] = $this->bancoAtual->saldo_inicial;
      $this->banco['saldo_atual'] = $this->bancoAtual->saldo_atual;
    } catch (ModelNotFoundException $e) {
      $this->error('O banco não existe.', redirectTo: '/financas/bancos');
    }
  }

  #[Title('Financas - Bancos - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.bancos.edicao');
  }

  public function editar(): void
  {
    $this->validate(rules: [
      'banco.nome' => ['required', 'max:255'],
      'banco.tipo' => ['required'],
      'banco.saldo_inicial' => ['required'],
      'banco.saldo_atual' => ['required'],
    ], messages: [
      'required' => 'O campo é obrigatório',
      'banco.nome.max' => 'O máximo de caracteres do nome é de 255 caracteres'
    ]);

    $this->bancoAtual->update($this->banco);

    $this->success('Banco editado com sucesso', redirectTo: route('financas.bancos.listagem'));
  }
}
