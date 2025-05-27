<?php

namespace App\Livewire\Views\Financas\Categorias;

use App\Models\CategoriaFinanca;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Cadastro extends Component
{
  use Toast;

  public User $usuario;
  public array $categoria = [
    'nome' => null,
    'tipo' => null,
    'cor' => null
  ];

  public function mount(): void {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Categorias - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.categorias.cadastro');
  }

  public function cadastrar(): void {
    $this->validate(rules: [
      'categoria.nome' => ['required', 'max:100'],
      'categoria.tipo' => ['required'],
      'categoria.cor' => ['required', 'hex_color']
    ], messages: [
      'required' => 'O campo é obrigatório.',
      'categoria.nome.max' => 'O nome deve conter no máximo 100 caracteres.',
      'categoria.cor.hex_color' => 'A cor é inválida'
    ]);

    $categoria = new CategoriaFinanca($this->categoria);

    $this->usuario->categoriaFinancas()->save($categoria);

    $this->success('Categoria cadastrada com sucesso', redirectTo: route('financas.categorias.listagem'));
  }
}
