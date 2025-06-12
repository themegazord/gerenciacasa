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
  <h1 class="text-2xl font-bold mb-6">Baixa das baixas</h1>

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
    {{ auth()->user()->retornaFormaPagamento($baixa->forma_pagamento) }}
    @endscope

    @scope('actions', $baixa)
    <x-dropdown>
      <x-menu-item title="Visualizar" icon="o-eye" wire:click="setBaixaAtual({{ $baixa->id }}, 'visualizacao')" />
      <x-menu-item title="Editar" icon="o-pencil-square" />
      <x-menu-item title="Deletar" icon="o-trash" wire:click="setBaixaAtual({{ $baixa->id }}, 'remocao')" />
    </x-dropdown>
    @endscope
  </x-table>

  {{-- modal para visualizacao dos dados da baixa --}}

  <x-modal wire:model="modalVisualizacao" class="backdrop-blur" box-class="max-w-3xl w-11/12" separator>
    @if ($baixaAtual)
    <x-slot:title>
      Detalhes da baixa: {{ $baixaAtual->id }}
    </x-slot:title>

    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">Descrição da baixa:</p>
          <p class="text-lg">{{ $baixaAtual->descricao }}</p>
        </x-card>
      </div>
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-success">Valor:</p>
          <p class="text-lg">R$ {{ number_format($baixaAtual->valor, 2, ',', '.') }}</p>
        </x-card>
      </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">Data da recebimento:</p>
          <p class="text-lg">{{ \Carbon\Carbon::parse($baixaAtual->data_baixa)->rawFormat('d/m/Y') }}</p>
        </x-card>
      </div>
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">Forma de pagamento</p>
          <p class="text-lg">{{ auth()->user()->retornaFormaPagamento($baixaAtual->forma_pagamento) }}</p>
        </x-card>
      </div>
    </div>

    @if ($baixaAtual->observacao)
    <x-card shadow>
      <p class="card-title text-primary">Observação:</p>
      <p class="text-lg">{{ $baixaAtual->observacoes }}</p>
    </x-card>
    @endif
    @endif
  </x-modal>

  {{-- modal para visualizacao dos dados da baixa --}}

</div>
