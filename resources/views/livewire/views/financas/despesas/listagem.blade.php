@php
$configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];
@endphp
<div class="p-4 md:p-6">
  <p class="text-2xl font-bold mb-6">Despesas</p>
  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model.live.debounce="pesquisa" label="Pesquisa" placeholder="Nome, descrição, observação..." inline />
    </div>
    <div class="flex-1">
      <x-datepicker label="Pagamento" wire:model.change="data_pagamento" icon="o-calendar" :config="$configuracaoDatetime" inline />
    </div>
    <div class="flex flex-col md:flex-row gap-2 flex-1">
      <x-button label="Resetar filtros" icon="o-funnel" wire:click="resetaFiltros" class="btn btn-primary" />
      <x-button label="Cadastrar" icon="o-plus" link="{{route('financas.despesas.cadastro')}}" class="btn btn-success" />
    </div>
  </div>
</div>
