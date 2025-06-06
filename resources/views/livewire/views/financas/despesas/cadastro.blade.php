@php
  $recorrencia = [
    ['id' => 1, 'name' => 'Sim'],
    ['id' => 0, 'name' => 'Não'],
  ];

  $bancos = auth()->user()->bancos;
  $categorias = auth()->user()->categoriaFinancas->where('tipo', 'despesa')
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Cadastro de despesas</h1>
  <x-form wire:submit.prevent="cadastrar">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-select label="Banco" wire:model="despesa.banco_id" :options="$bancos" option-label="nome" placeholder="Selecione o banco" required />
      </div>
      <div class="flex-1">
        <x-select label="Categorias" wire:model="despesa.categoria_id" :options="$categorias" option-label="nome" placeholder="Selecione a categoria" required />
      </div>
      <div class="flex-1">
        <x-select label="Essa despesa é recorrente?" wire:model.change="despesa.recorrente" :options="$recorrencia" placeholder="Selecione se vai haver recorrência..." required />
      </div>
      @if ($despesa['recorrente'])
      <div class="flex-1">
        <x-input label="Quantidades de recorrência" wire:model="qtd_recorrencia" type="number" min="1" />
      </div>
      @endif
    </div>
    <div class="mb-4">
      <x-input label="Descrição da despesa" wire:model="despesa.descricao" placeholder="Insira a descrição da categoria..." required />
    </div>
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-input label="Valor" wire:model="despesa.valor" prefix="R$" locale="pt-BR" money required />
      </div>
      <div class="flex-1">
        <x-input label="Valor em aberto" hint="Deixar zerado vai dizer que o valor em aberto é o mesmo que o valor da despesa" wire:model="despesa.valor_aberto" prefix="R$" locale="pt-BR" money />
      </div>
      <div class="flex-1">
        <x-datetime label="Data do vencimento" wire:model="despesa.data_vencimento" required />
      </div>
    </div>
    <div class="mb-4">
      <x-textarea label="Observação" placeholder="Insira a observação da despesa..." wire:model="despesa.observacao" />
    </div>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-error" link="{{ route('financas.despesas.listagem') }}" />
      <x-button label="Cadastrar" class="btn btn-success" type="submit" wire:loading.attr="disabled" spinner="cadastrar" />
    </x-slot:actions>
  </x-form>
</div>
