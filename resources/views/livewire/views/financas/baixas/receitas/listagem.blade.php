@php
$configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];

$headers = [
['key' => 'id', 'label' => '#'],
['key' => 'descricao', 'label' => 'Descrição'],
['key' => 'valor', 'label' => 'Valor'],
['key' => 'forma_pagamento', 'label' => 'Forma de Pagamento'],
['key' => 'data_baixa', 'label' => 'Data do recebimento'],
];
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
    <div class="flex flex-col md:flex-row gap-2 flex-1">
      <x-button label="Resetar filtros" icon="o-funnel" wire:click="resetaFiltros" class="btn btn-primary" />
      <x-button label="Cadastrar" icon="o-plus" link="{{route('financas.baixas.receitas.cadastro')}}" class="btn btn-success" />
    </div>
  </div>

  <x-table :headers="$headers" :rows="$baixas" with-pagination>
    @scope('cell_valor', $baixa)
    R$ {{ number_format($baixa->valor, 2, ',', '.') }}
    @endscope

    @scope('cell_data_baixa', $baixa)
    {{ \Carbon\Carbon::parse($baixa->data_baixa)->format('d/m/Y') }}
    @endscope

    @scope('cell_forma_pagamento', $baixa)
    {{ collect(auth()->user()->formasPagamento())->firstWhere('id', $baixa->forma_pagamento)['name'] ?? null }}
    @endscope

    @scope('actions', $baixa)
    <x-dropdown>
      <x-menu-item title="Visualizar" icon="o-eye" wire:click="setBaixaAtual({{ $baixa->id }}, 'visualizacao')" />
      <x-menu-item title="Editar" icon="o-pencil-square" />
      <x-menu-item title="Deletar" icon="o-trash" wire:click="setBaixaAtual({{ $baixa->id }}, 'remocao')" />
    </x-dropdown>
    @endscope
  </x-table>

</div>
