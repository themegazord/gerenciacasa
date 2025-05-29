@php
  $configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Receitas</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model="pesquisa" label="Pesquisa" placeholder="Nome, descrição, observação..." inline/>
    </div>
    <div class="flex-1">
      <x-datepicker label="Recebimento" wire:model="data_recebimento" icon="o-calendar" :config="$configuracaoDatetime" inline/>
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" link="{{route('financas.receitas.cadastro')}}" class="btn btn-success"/>
    </div>
  </div>
</div>
