<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Bancos</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-1">
      <x-input label="Pesquisa" placeholder="Nome, tipo, agência, conta..." icon="o-magnifying-glass" inline />
    </div>
    <div class="flex items-center gap-2">
      <x-toggle id="ativo" label="Ativo?" wire:model="consultaAtivo"/>
    </div>
    <div>
      <x-button label="Pesquisar" icon="o-magnifying-glass" class="btn btn-primary w-full md:w-auto" />
    </div>
    <div>
      <x-button label="Cadastrar" icon="o-plus" class="btn btn-success w-full md:w-auto" link="{{ route('financas.bancos.cadastro') }}" />
    </div>
  </div>

  @php
  $headers = [
    ['key' => 'id', 'label' => '#'],
    ['key' => 'nome', 'label' => 'Nome'],
    ['key' => 'tipo', 'label' => 'Tipo'],
    ['key' => 'saldo_atual', 'label' => 'Saldo atual'],
  ];

  $bancos = \App\Models\Banco::query()->paginate(5);
  @endphp

  <x-table :headers="$headers" :rows="$bancos" empty-text="Não contêm bancos cadastrados" show-empty-text with-pagination>
    @scope('cell_tipo', $banco)
    {{ $banco->tiposBancos() }}
    @endscope

    @scope('actions', $banco)
    <div class="flex flex-row">
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-eye" wire:click="setVisualizacaoBanco({{ $banco->id }})" />
        </x-slot:trigger>
        <x-slot:content>
          Visualizar
        </x-slot:content>
      </x-popover>
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-pencil-square" link="{{ route('financas.bancos.edicao', ['id' => $banco->id]) }}"/>
        </x-slot:trigger>
        <x-slot:content>
          Editar
        </x-slot:content>
      </x-popover>
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-eye-slash" />
        </x-slot:trigger>
        <x-slot:content>
          Inativar
        </x-slot:content>
      </x-popover>
    </div>
    @endscope
  </x-table>

  <!-- modal de visualizacao dos dados -->

  <x-modal wire:model="modalVisualizacao" title="Descrição do banco" class="backdrop-blur" box-class="max-w-3xl w-11/12">
    @if ($bancoAtual !== null)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <p class="font-semibold text-sm text-gray-400">Nome</p>
        <p class="text-lg font-medium">{{ $bancoAtual->nome }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm text-gray-400">Tipo</p>
        <p class="text-lg font-medium">{{ $bancoAtual->tiposBancos() }}</p>
      </div>

      <div>
        <p class="font-semibold text-sm text-gray-400">Saldo Inicial</p>
        <p class="text-lg font-medium text-green-500">R$ {{ number_format($bancoAtual->saldo_inicial, 2, ',', '.') }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm text-gray-400">Saldo Atual</p>
        <p class="text-lg font-medium text-blue-500">R$ {{ number_format($bancoAtual->saldo_atual, 2, ',', '.') }}</p>
      </div>

      <div>
        <p class="font-semibold text-sm text-gray-400">Agência</p>
        <p class="text-lg font-medium">{{ $bancoAtual->agencia }}</p>
      </div>
      <div>
        <p class="font-semibold text-sm text-gray-400">Nº da Conta</p>
        <p class="text-lg font-medium">{{ $bancoAtual->numero_conta }}</p>
      </div>

      <div class="md:col-span-2">
        <p class="font-semibold text-sm text-gray-400">Descrição</p>
        <p class="text-base">{{ $bancoAtual->descricao ?: '—' }}</p>
      </div>
    </div>
    @endif
  </x-modal>


  <!-- modal de visualizacao dos dados -->
</div>
