<?php

namespace App\Livewire\Views\Autenticacao;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Login extends Component
{
  use Toast;
  public ?string $email = null;
  public ?string $senha = null;
  public bool $manter_conectado = false;

  #[Title('Login')]
  public function render()
  {
    return view('livewire.views.autenticacao.login');
  }

  public function home(): void {
    $this->redirect(route('home'));
  }

  public function login(): void {
    $this->validate(rules: [
      'email' => ['required', 'email', 'max:255'],
      'senha' => ['required']
    ], messages: [
      'required' => 'O campo é obrigatório.',
      'email.email' => 'O email é inválido',
      'email.max' => 'O email deve conter no máximo 255 caracteres'
    ]);

    if (!Auth::attempt(['email' => $this->email, 'password' => $this->senha])) {
      $this->warning('Email e senha inválidos');
      return;
    }

    Auth::login(User::query()->where('email', $this->email)->first(), $this->manter_conectado);

    $this->redirect(route('dashboard'));
  }
}
