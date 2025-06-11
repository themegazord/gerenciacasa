@php
  $configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Baixa das Receitas</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model.live.debounce="pesquisa" label="Pesquisa" placeholder="Nome, observações, valor..." icon="o-magnifying-glass" inline />
    </div>
    <div class="flex-1">
      <x-datepicker label="Data da baixa" wire:model.change="data_baixa" icon="o-calendar" :config="$configuracaoDatetime" inline />
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" class="btn btn-success w-full md:w-auto" link="{{ route('financas.bancos.cadastro') }}" />
    </div>
  </div>

</div>
