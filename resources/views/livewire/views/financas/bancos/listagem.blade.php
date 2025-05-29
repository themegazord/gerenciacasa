@php
$tiposBancos = [
['tipo' => 'corrente', 'label' => 'Conta Corrente'],
['tipo' => 'poupanca', 'label' => 'Conta Poupança'],
['tipo' => 'carteira', 'label' => 'Carteira Física'],
['tipo' => 'digital', 'label' => 'Conta Digital'],
['tipo' => 'investimento', 'label' => 'Investimentos'],
['tipo' => 'caixa_empresa', 'label' => 'Caixa da Empresa'],
['tipo' => 'cartao_credito', 'label' => 'Cartão de Crédito'],
['tipo' => 'moeda_estrangeira', 'label' => 'Conta em Moeda Estrangeira'],
['tipo' => 'outro', 'label' => 'Outro'],
];

$headers = [
['key' => 'id', 'label' => '#'],
['key' => 'nome', 'label' => 'Nome'],
['key' => 'tipo', 'label' => 'Tipo'],
['key' => 'saldo_atual', 'label' => 'Saldo atual'],
];

@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Bancos</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-3">
      <x-input wire:model.live.debounce="pesquisa" label="Pesquisa" placeholder="Nome, tipo, agência, conta..." icon="o-magnifying-glass" inline />
    </div>
    <div class="flex-2">
      <x-select label="Tipo do banco" wire:model.live.debounce="pesquisaTipoBanco" :options="$tiposBancos" option-value="tipo" inline option-label="label" placeholder="Selecione o tipo do banco..." />
    </div>
    <div class="flex-1">
      <x-toggle id="ativo" label="Ativo?" wire:model.live.debounce="consultaAtivo" />
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" class="btn btn-success w-full md:w-auto" link="{{ route('financas.bancos.cadastro') }}" />
    </div>
  </div>

  <x-table :headers="$headers" :rows="$bancos" empty-text="Não contêm bancos cadastrados" show-empty-text with-pagination>
    @scope('cell_tipo', $banco)
    {{ $banco->tiposBancos() }}
    @endscope

    @scope('actions', $banco)
    <x-dropdown>
      <x-menu-item title="Visualizar" icon="o-eye" wire:click="setVisualizacaoBanco({{ $banco->id }})" />
      <x-menu-item title="Editar" icon="o-pencil-square" link="{{ route('financas.bancos.edicao', ['id' => $banco->id]) }}" />
      <x-menu-item title="{{ !$banco->trashed() ? 'Inativar' : 'Restaurar' }}" icon="o-arrow-path-rounded-square" wire:click="setInativacaoBanco({{ $banco->id }})" />
    </x-dropdown>
    @endscope
  </x-table>

  <!-- modal de visualizacao dos dados -->

  <x-modal wire:model="modalVisualizacao" title="Descrição do banco" class="backdrop-blur" box-class="max-w-3xl w-11/12">
    @if ($bancoAtual !== null)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <p class="font-semibold text-sm">Nome</p>
        <p class="text-lg font-medium">{{ $bancoAtual->nome }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm">Tipo</p>
        <p class="text-lg font-medium">{{ $bancoAtual->tiposBancos() }}</p>
      </div>

      <div>
        <p class="font-semibold text-sm">Saldo Inicial</p>
        <p class="text-lg font-medium text-green-500">R$ {{ number_format($bancoAtual->saldo_inicial, 2, ',', '.') }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm">Saldo Atual</p>
        <p class="text-lg font-medium text-blue-500">R$ {{ number_format($bancoAtual->saldo_atual, 2, ',', '.') }}</p>
      </div>

      <div>
        <p class="font-semibold text-sm">Agência</p>
        <p class="text-lg font-medium">{{ $bancoAtual->agencia }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm">Nº da Conta</p>
        <p class="text-lg font-medium">{{ $bancoAtual->numero_conta }}</p>
      </div>

      <div class="md:col-span-2">
        <p class="font-semibold text-sm">Descrição</p>
        <p class="text-base">{{ $bancoAtual->descricao ?: '—' }}</p>
      </div>
    </div>
    @endif
  </x-modal>

  <!-- modal de visualizacao dos dados -->

  {{-- modal de inativacao do banco  --}}

  <x-modal wire:model="modalInativacao" title="Inativação do banco" class="backdrop-blur" box-class="max-w-xl w-11/12">
    @if ($bancoAtual !== null)
    <p class="font-semibold text-lg">Você pretende realmente inativar esse banco? Todas as movimentações em relatórios não serão contabilizados e nenhuma movimentação não poderá ser adicinado no banco inativo.</p>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-primary" @click="$wire.set('modalInativacao', false)" />
      <x-button label="Inativar" class="btn btn-error" wire:click="inativarBanco" wire:loading.attr="disabled" spinner="inativarBanco" />
    </x-slot:actions>
    @endif
  </x-modal>

  {{-- modal de inativacao do banco  --}}
</div>
