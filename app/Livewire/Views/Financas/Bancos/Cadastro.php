<?php

namespace App\Livewire\Views\Financas\Bancos;

use App\Models\Banco;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Cadastro extends Component
{
  use Toast;

  public ?User $usuario;
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

  public function mount(): void {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Bancos - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.bancos.cadastro');
  }

  public function cadastrar(): void {
    $this->validate(rules: [
      'banco.nome' => ['required', 'max:255'],
      'banco.tipo' => ['required'],
      'banco.saldo_inicial' => ['required'],
      'banco.saldo_atual' => ['required'],
    ], messages: [
      'required' => 'O campo é obrigatório',
      'banco.nome.max' => 'O máximo de caracteres do nome é de 255 caracteres'
    ]);

    $banco = new Banco($this->banco);

    $this->usuario->bancos()->save($banco);

    $this->success('Banco cadastrado com sucesso', redirectTo: route('financas.bancos.listagem'));
  }
}
