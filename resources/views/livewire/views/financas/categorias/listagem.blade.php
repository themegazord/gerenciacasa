@php
$tiposCategorias = [
['tipo' => 'receita', 'label' => 'Receitas'],
['tipo' => 'despesa', 'label' => 'Despesas'],
];

$headers = [
['key' => 'id', 'label' => '#'],
['key' => 'nome', 'label' => 'Categoria'],
['key' => 'tipo', 'label' => 'Tipo']
];
@endphp
<div class="p-4 md:p-6">
  <p class="text-2xl font-bold mb-6">Categorias</p>
  <div class="flex flex-col md:flex-row md:items-end gap-4 mt-4 mb-8">
    <div class="flex-3">
      <x-input label="Nome da categoria" placeholder="Insira o nome da categoria que deseje consultar..." wire:model.live.debounce="pesquisa" inline />
    </div>
    <div class="flex-2">
      <x-select label="Tipo da categoria" placeholder="Escolha o tipo..." wire:model.live.debounce="pesquisaTipo" :options="$tiposCategorias" option-value="tipo" inline option-label="label" inline />
    </div>
    <div class="flex-1">
      <x-toggle label="Ativo?" wire:model.live.debounce="pesquisaAtivo" />
    </div>
    <div class="flex-1">
      <x-button label="Cadastrar" icon="o-plus" class="w-full md:w-auto btn btn-success" wire:loading.attr="disabled" link="{{ route('financas.categorias.cadastro') }}" />
    </div>
  </div>

  <x-table :headers="$headers" :rows="$categorias" with-pagination>
    @scope('cell_tipo', $categoria)
    @php
    $tipo = $categoria->tipo; // é um enum se estiver com cast
    @endphp
    <x-badge class="badge-soft {{ $tipo->badgeClass() }}" value="{{ $tipo->label() }}" />
    @endscope

    @scope('actions', $categoria)
    <div class="flex flex-row">
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-eye" wire:click="setCategoriaVisualizacao({{ $categoria->id }})"/>
        </x-slot:trigger>
        <x-slot:content>
          Visualizar
        </x-slot:content>
      </x-popover>
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-pencil-square" link="{{ route('financas.categorias.edicao', ['id' => $categoria->id]) }}" />
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
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-trash" />
        </x-slot:trigger>
        <x-slot:content>
          Remover
        </x-slot:content>
      </x-popover>
    </div>
    @endscope
  </x-table>

  <x-modal wire:model="modalVisualizacao" class="backdrop-blur" box-class="max-w-3xl w-11/12">
    @if ($categoriaAtual)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <p class="text-sm text-gray-500">Nome</p>
        <p class="text-lg font-bold">{{ $categoriaAtual->nome }}</p>
      </div>

      <div>
        <p class="text-sm text-gray-500">Tipo</p>
        <x-badge
          class="badge-soft {{ $categoriaAtual->tipo->badgeClass() }}"
          value="{{ $categoriaAtual->tipo->label() }}" />
      </div>

      <div>
        <p class="text-sm text-gray-500">Status</p>
        <x-badge
          class="badge-soft {{ !$categoriaAtual->trashed() ? 'badge-success' : 'badge-error' }}"
          value="{{ !$categoriaAtual->trashed() ? 'Ativo' : 'Inativo' }}" />
      </div>
    </div>
    @else
    <div class="text-center text-gray-500 py-8">
      Nenhuma categoria selecionada.
    </div>
    @endif
  </x-modal>

</div>
