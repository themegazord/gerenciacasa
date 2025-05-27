<?php

namespace App\Livewire\Views\Financas\Categorias;

use App\Models\CategoriaFinanca;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Edicao extends Component
{
  use Toast;

  public array $categoria = [
    'nome' => null,
    'tipo' => null,
    'cor' => null
  ];
  public CategoriaFinanca $categoriaAtual;

  public function mount(int $id): void {
    try {
      $this->categoriaAtual = CategoriaFinanca::query()->findOrFail($id);
      $this->categoria['tipo'] = $this->categoriaAtual->tipo;
      $this->categoria['cor'] = $this->categoriaAtual->cor;
    } catch (ModelNotFoundException $e) {
      $this->warning('Categoria não existe.', redirectTo: route('financas.categorias.listagem'));
    }
  }

  #[Title('Finanças - Categorias - Edição')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.categorias.edicao');
  }

  public function editar(): void {
    $this->validate(rules: [
      'categoria.nome' => ['required', 'max:100'],
      'categoria.tipo' => ['required'],
      'categoria.cor' => ['required', 'hex_color']
    ], messages: [
      'required' => 'O campo é obrigatório.',
      'categoria.nome.max' => 'O nome deve conter no máximo 100 caracteres.',
      'categoria.cor.hex_color' => 'A cor é inválida'
    ]);

    $this->categoriaAtual->update($this->categoria);

    $this->success('Categoria editada com sucesso', redirectTo: route('financas.categorias.listagem'));
  }
}
