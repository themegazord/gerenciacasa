@php
  $configuracaoDatetime = ['altFormat' => 'd/m/Y', 'mode' => 'range'];

  $headers = [
    ['key' => 'id', 'label' => '#'],
    ['key' => 'descricao', 'label' => 'Descrição'],
    ['key' => 'valor', 'label' => 'Valor'],
    ['key' => 'data', 'label' => 'Data da movimentação'],
    ['key' => 'banco.nome', 'label' => 'Banco'],
    ['key' => 'categoria.nome', 'label' => 'Categoria'],
    ['key' => 'recorrente', 'label' => 'Recorrente?'],
  ];
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Receitas</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model.live.debounce="pesquisa" label="Pesquisa" placeholder="Nome, descrição, observação..." inline/>
    </div>
    <div class="flex-1">
      <x-datepicker label="Recebimento" wire:model.change="data_recebimento" icon="o-calendar" :config="$configuracaoDatetime" inline/>
    </div>
    <div class="flex flex-col md:flex-row gap-2 flex-1">
      <x-button label="Resetar filtros" icon="o-funnel" wire:click="resetaFiltros" class="btn btn-primary"/>
      <x-button label="Cadastrar" icon="o-plus" link="{{route('financas.receitas.cadastro')}}" class="btn btn-success"/>
    </div>
  </div>

  <x-table :rows="$receitas" :headers="$headers" with-pagination>
    @scope('cell_valor', $receita)
      R$ {{ number_format($receita->valor, 2, ',', '.') }}
    @endscope

    @scope('cell_recorrente', $receita)
      @if ($receita->recorrente)
        @if ($receita->receita_pai_id)
          Parcela filha
        @else
          Parcela pai
        @endif
      @else
        Não
      @endif
    @endscope

    @scope('cell_data', $receita)
      {{ Carbon\Carbon::parse($receita->data)->format('d/m/Y') }}
    @endscope

    @scope('actions', $receita)
      <x-dropdown>
        <x-menu-item title="Visualizar" icon="o-eye" />
        <x-menu-item title="Editar" icon="o-pencil-square" />
        <x-menu-item title="Deletar" icon="o-trash" />
      </x-dropdown>
    @endscope
  </x-table>
</div>
