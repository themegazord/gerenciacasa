<?php

namespace App\Livewire\Views\Financas\Receitas;

use App\Models\Receita;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

class Cadastro extends Component
{
  use Toast;

  public Authenticatable|User $usuario;
  public array $receita = [
    'banco_id' => null,
    'categoria_id' => null,
    'descricao' => null,
    'valor' => null,
    'data' => null,
    'observacao' => null,
    'recorrente' => false,
  ];
  public ?int $qtd_recorrencia = null;

  public function mount(): void {
    $this->usuario = Auth::user();
  }

  #[Title('Finanças - Receitas - Cadastro')]
  #[Layout('components.layouts.autenticado')]
  public function render()
  {
    return view('livewire.views.financas.receitas.cadastro');
  }

  public function cadastrar(): void
  {
    $rules = [
      'receita.banco_id' => ['required'],
      'receita.categoria_id' => ['required'],
      'receita.descricao' => ['required', 'max:100'],
      'receita.valor' => ['required'],
      'receita.data' => ['required'],
      'receita.recorrente' => ['required'],
    ];

    if ($this->receita['recorrente']) {
      $rules['qtd_recorrencia'] = ['required', 'integer', 'min:1'];
    }

    $this->validate($rules, [
      'required' => 'O campo é obrigatório.',
      'receita.descricao.max' => 'A descrição deve conter no máximo 100 caracteres.',
      'integer' => 'Informe o número de meses usando números.',
      'qtd_recorrencia.min' => 'Aceitamos o mínimo de 1 mês.',
    ]);

    if ($this->receita['recorrente']) {
      $dataBase = Carbon::parse($this->receita['data']);
      $receitaPai = $this->usuario->receitas()->save(new Receita($this->receita));
      for ($i = 1; $i <= $this->qtd_recorrencia; $i += 1) {
        $novaData = (clone $dataBase)->addMonths($i);
        $this->usuario->receitas()->save(new Receita([
          ...$this->receita,
          'data' => $novaData,
          'receita_pai_id' => $receitaPai->id
        ]));
      }
    }

    $this->success('Receitas registrada com sucesso', redirectTo: route('financas.receitas.listagem'));
  }
}
