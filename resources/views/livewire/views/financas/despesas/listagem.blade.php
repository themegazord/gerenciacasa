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

  {{-- modal de visualizacao de despesa --}}
  <x-modal wire:model="modalVisualizacao" class="backdrop-blur" box-class="max-w-2xl w-11/12" separator>
    @if ($despesaAtual)
    <x-slot:title>Detalhes da despesa: #{{ $despesaAtual->id }} </x-slot:title>

    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">Descrição da despesa:</p>
          <p class="text-lg">{{ $despesaAtual->descricao }}</p>
        </x-card>
      </div>
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-error">Valor:</p>
          <p class="text-lg">R$ {{ number_format($despesaAtual->valor, 2, ',', '.') }}</p>
        </x-card>
      </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">Data do vencimento:</p>
          <p class="text-lg">{{ \Carbon\Carbon::parse($despesaAtual->data)->rawFormat('d/m/Y') }}</p>
        </x-card>
      </div>
      <div class="flex-1">
        <x-card shadow>
          <p class="card-title text-primary">É recorrente?</p>
          <p class="text-lg">{{ $despesaAtual->recorrente ? 'Sim, é uma parcela ' : 'Não' }} {{ $despesaAtual->despesa_pai_id ? 'filha.' : 'pai.' }}</p>
        </x-card>
      </div>
    </div>

    @if ($despesaAtual->observacao)
    <x-card shadow>
      <p class="card-title text-primary">Observação:</p>
      <p class="text-lg">{{ $despesaAtual->observacao }}</p>
    </x-card>
    @endif

    @if ($despesaAtual->ehRecorrente())
    @if (!$despesaAtual->despesa_pai_id)
    <x-card shadow>
      <p class="card-title text-primary">Parcelas:</p>
      <x-table :headers="$headersDemo" :rows="$despesaAtual->despesas_filhas()->paginate(5)">
        @scope('cell_valor', $despesa)
        R$ {{ number_format($despesa->valor, 2, ',', '.') }}
        @endscope

        @scope('cell_data_vencimento', $despesa)
        {{ Carbon\Carbon::parse($despesa->data_vencimento)->format('d/m/Y') }}
        @endscope
      </x-table>
    </x-card>
    @else
    <x-card shadow>
      <p class="card-title text-primary">Id do código pai: #{{ $despesaAtual->despesa_pai_id }}</p>
    </x-card>
    @endif

    @endif

    @endif
  </x-modal>
  {{-- modal de visualizacao de despesa --}}

    {{-- modal de remoção da despesa --}}

  <x-modal wire:model="modalRemocao" class="backdrop-blur" box-class="max-w-xl w-11/12">
    @if ($despesaAtual)
    <p class="font-semibold text-lg">Você deseja remover essa despesa? Lembrando que, a partir do momento que essa despesa está em uso em alguma baixa não será possivel a remoção. Caso seja a parcela pai, todas as filhas irão se apagar.</p>

    <x-slot:actions>
      <x-button label="Cancelar" @click="$wire.set('modalRemocao', false)" class="btn btn-primary" />
      <x-button label="Remover" wire:click="removerDespesa" class="btn btn-error" wire:loading.attr="disabled" spinner="removerDespesa" />
    </x-slot:actions>
    @endif
  </x-modal>

  {{-- modal de remoção da despesa --}}


  {{-- modal de questionamento sobre remocao de parcela pai --}}

  <x-modal wire:model="modalRemocaoDespesaPai" class="backdrop-blur" box-class="max-w-xl w-11/12">
    @if ($despesaAtual)
    <p class="font-semibold text-lg">Você deseja apagar todas as parcelas filhas ou apenas retirar o vinculo e deixá-las como parcelas normais?</p>

    <x-slot:actions>
      <x-button label="Cancelar" @click="$wire.set('modalRemocaoDespesaPai', false)" class="btn btn-primary" />
      <x-button label="Apagar todas" wire:click="removerDespesaPai(true)" class="btn btn-error" wire:loading.attr="disabled" spinner="removerDespesaPai" />
      <x-button label="Retirar o vinculo" wire:click="removerDespesaPai(false)" class="btn btn-error" wire:loading.attr="disabled" spinner="removerDespesaPai" />
    </x-slot:actions>
    @endif
  </x-modal>

  {{-- modal de questionamento sobre remocao de parcela pai --}}
</div>
