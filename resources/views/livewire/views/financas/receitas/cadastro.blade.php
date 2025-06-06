@php
  $recorrencia = [
    ['id' => 1, 'name' => 'Sim'],
    ['id' => 0, 'name' => 'Não'],
  ];

  $bancos = auth()->user()->bancos;
  $categorias = auth()->user()->categoriaFinancas->where('tipo', 'receita')
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Cadastro de receitas</h1>
  <x-form wire:submit.prevent="cadastrar">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-select label="Banco" wire:model="receita.banco_id" :options="$bancos" option-label="nome" placeholder="Selecione o banco" required/>
      </div>
      <div class="flex-1">
        <x-select label="Categorias" wire:model="receita.categoria_id" :options="$categorias" option-label="nome" placeholder="Selecione a categoria" required/>
      </div>
      <div class="flex-1">
        <x-select label="Essa receita é recorrente?" wire:model.change="receita.recorrente" :options="$recorrencia" placeholder="Selecione se vai haver recorrência..." required/>
      </div>
      @if ($receita['recorrente'])
        <div class="flex-1">
          <x-input label="Quantidades de recorrência" wire:model="qtd_recorrencia" type="number" min="1"/>
        </div>
      @endif
    </div>
    <div class="mb-4">
      <x-input label="Descrição da receita" wire:model="receita.descricao" placeholder="Insira a descrição da categoria..." required/>
    </div>
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-input label="Valor" wire:model="receita.valor" prefix="R$" locale="pt-BR" money required/>
      </div>
      <div class="flex-1">
        <x-datetime label="Data da movimentação" wire:model="receita.data"  required/>
      </div>
    </div>
    <div class="mb-4">
      <x-textarea label="Observação" placeholder="Insira a observação da receita..." wire:model="receita.observacao"/>
    </div>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-error" link="{{ route('financas.receitas.listagem') }}"/>
      <x-button label="Cadastrar" class="btn btn-success" type="submit" wire:loading.attr="disabled" spinner="cadastrar" />
    </x-slot:actions>
  </x-form>
</div>
