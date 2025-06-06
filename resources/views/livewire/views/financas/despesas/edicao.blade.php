@php
  $bancos = auth()->user()->bancos;
  $categorias = auth()->user()->categoriaFinancas->where('tipo', 'despesa')
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Edição de despesas</h1>
  <x-form wire:submit.prevent="edicao">
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-select label="Banco" wire:model="despesa.banco_id" :options="$bancos" option-label="nome" placeholder="Selecione o banco" required />
      </div>
      <div class="flex-1">
        <x-select label="Categorias" wire:model="despesa.categoria_id" :options="$categorias" option-label="nome" placeholder="Selecione a categoria" required />
      </div>
    </div>
    <div class="mb-4">
      <x-input label="Descrição da despesa" wire:model.fill="despesa.descricao" value="{{ $despesaAtual->descricao }}" placeholder="Insira a descrição da categoria..." required />
    </div>
    <div class="flex flex-col md:flex-row gap-4 mb-4">
      <div class="flex-1">
        <x-input label="Valor" wire:model.fill="despesa.valor" value="{{ $despesaAtual->valor }}" prefix="R$" locale="pt-BR" money required />
      </div>
      <div class="flex-1">
        <x-datetime label="Data do vencimento" wire:model.fill="despesa.data_vencimento" value="{{ $despesaAtual->data_vencimento }}" required />
      </div>
    </div>
    <div class="mb-4">
      <x-textarea label="Observação" placeholder="Insira a observação da despesa..." wire:model.fill="despesa.observacao" value="{{ $despesaAtual->observacao }}" />
    </div>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-error" link="{{ route('financas.despesas.listagem') }}" />
      <x-button label="Salvar" class="btn btn-success" type="submit" wire:loading.attr="disabled" spinner="edicao" />
    </x-slot:actions>
  </x-form>
</div>
