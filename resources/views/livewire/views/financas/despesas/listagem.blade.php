@php
$configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];
$headers = [
['key' => 'id', 'label' => '#'],
['key' => 'descricao', 'label' => 'Descrição'],
['key' => 'valor', 'label' => 'Valor'],
['key' => 'valor_aberto', 'label' => 'Saldo'],
['key' => 'data_vencimento', 'label' => 'Data do vencimento'],
['key' => 'banco.nome', 'label' => 'Banco'],
['key' => 'categoria.nome', 'label' => 'Categoria'],
['key' => 'recorrente', 'label' => 'Recorrente?'],
];

$headersDemo = [
['key' => 'id', 'label' => '#'],
['key' => 'descricao', 'label' => 'Descrição'],
['key' => 'valor', 'label' => 'Valor'],
['key' => 'valor_aberto', 'label' => 'Saldo'],
['key' => 'data_vencimento', 'label' => 'Data do vencimento'],
];
@endphp
<div class="p-4 md:p-6">
  <p class="text-2xl font-bold mb-6">Despesas</p>
  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model.live.debounce="pesquisa" label="Pesquisa" placeholder="Nome, descrição, observação..." inline />
    </div>
    <div class="flex-1">
      <x-datepicker label="Vencimento" wire:model.change="data_vencimento" icon="o-calendar" :config="$configuracaoDatetime" inline />
    </div>
    <div class="flex-1">
      <x-toggle label="Ativo?" wire:model.debounce.live="ativo" />
    </div>
    <div class="flex flex-col md:flex-row gap-2 flex-1">
      <x-button label="Resetar filtros" icon="o-funnel" wire:click="resetaFiltros" class="btn btn-primary" />
      <x-button label="Cadastrar" icon="o-plus" link="{{route('financas.despesas.cadastro')}}" class="btn btn-success" />
    </div>
  </div>

  <x-table :rows="$despesas" :headers="$headers">
    @scope('cell_valor', $despesa)
    R$ {{ number_format($despesa->valor, 2, ',', '.') }}
    @endscope
    @scope('cell_valor_aberto', $despesa)
    R$ {{ number_format($despesa->valor_aberto, 2, ',', '.') }}
    @endscope

    @scope('cell_recorrente', $despesa)
    @if ($despesa->recorrente)
    @if ($despesa->despesa_pai_id)
    Parcela filha
    @else
    Parcela pai
    @endif
    @else
    Não
    @endif
    @endscope

    @scope('cell_data_vencimento', $despesa)
    {{ Carbon\Carbon::parse($despesa->data_vencimento)->format('d/m/Y') }}
    @endscope

    @scope('actions', $despesa)
    <x-dropdown>
      <x-menu-item title="Visualizar" icon="o-eye" wire:click="setDespesaAtual({{ $despesa->id }}, 'visualizacao')" />
      <x-menu-item title="Editar" icon="o-pencil-square" link="{{ route('financas.despesas.edicao', ['id' => $despesa->id]) }}" />
      <x-menu-item title="Deletar" icon="o-trash" wire:click="setDespesaAtual({{ $despesa->id }}, 'remocao')" />
    </x-dropdown>
    @endscope
  </x-table>
</div>
