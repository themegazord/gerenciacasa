<?php

namespace App\Livewire\Views;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Home extends Component
{
  use Toast;

  public ?string $nome = null;
  public ?string $email = null;
  public ?string $senha = null;
  public ?string $confirmacao_senha = null;

  #[Title('Home')]
  public function render()
  {
    return view('livewire.views.home');
  }

  public function cadastrar(): void {
    $this->validate(rules: [
      'nome' => ['required', 'max:255'],
      'email' => ['required', 'max:255', 'email', 'unique:users,email'],
      'senha' => ['required'],
      'confirmacao_senha' => ['required', 'same:senha']
    ], messages: [
      'required' => 'O campo é obrigatório',
      'max' => 'O :attribute deve conter no máximo 255 caracteres.',
      'email.email' => 'O email é inválido',
      'email.unique' => 'O email já está sendo usado por outro usuário',
      'confirmacao_senha.same' => 'A confirmação da senha deve ser igual a senha'
    ]);

    $usuario = User::query()->create([
      'name' => $this->nome,
      'email' => $this->email,
      'password' => Hash::make($this->senha)
    ]);

    Auth::login($usuario);

    $this->success('Usuário criado com sucesso');
  }
}
