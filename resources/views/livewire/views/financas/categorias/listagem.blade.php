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
          <x-button icon="o-eye" wire:click="setCategoriaAtual({{ $categoria->id }}, 'visualizacao')" />
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
          <x-button icon="o-eye-slash" wire:click="setCategoriaAtual({{ $categoria->id }}, 'status')"/>
        </x-slot:trigger>
        <x-slot:content>
          {{ !$categoria->trashed() ? 'Inativar' : 'Restaurar' }}
        </x-slot:content>
      </x-popover>
      <x-popover>
        <x-slot:trigger>
          <x-button icon="o-trash" wire:click="setCategoriaAtual({{ $categoria->id }}, 'remocao')"/>
        </x-slot:trigger>
        <x-slot:content>
          Remover
        </x-slot:content>
      </x-popover>
    </div>
    @endscope
  </x-table>

  {{-- modal para visualizacao de categoria --}}
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
  {{-- modal para visualizacao de categoria --}}

  {{-- modal para requisicao de inativacao de categoria --}}
  <x-modal wire:model="modalAlteracaoStatusCategoria" class="backdrop-blur" box-class="max-w-xl w-11/12">
    @if ($categoriaAtual)
    <p class="font-semibold text-lg">Você pretende realmente alterar o status dessa categoria? Lembre-se que para inativar, você deverá não ter nenhuma receita ou despesa usando ele.</p>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn {{ !$categoriaAtual->trashed() ? 'btn-primary' : 'btn-error' }}" @click="$wire.set('modalAlteracaoStatusCategoria', false)" />
      <x-button label="{{ !$categoriaAtual->trashed() ? 'Inativar' : 'Restaurar' }}" class="btn {{ !$categoriaAtual->trashed() ? 'btn-error' : 'btn-primary' }}" wire:click="alterarStatusCategoria" wire:loading.attr="disabled" spinner="alterarStatusCategoria" />
    </x-slot:actions>
    @endif
  </x-modal>
  {{-- modal para requisicao de inativacao de categoria --}}

  {{-- modal para requisicao de remoção de categoria --}}
  <x-modal wire:model="modalRemocaoCategoria" class="backdrop-blur" box-class="max-w-xl w-11/12">
    @if ($categoriaAtual)
      <p class="font-semibold text-lg">Você deseja remover essa categoria? Lembrando que, a partir do momento que essa categoria está em uso em alguma receita ou despesa, não será possivel a remoção.</p>

      <x-slot:actions>
        <x-button label="Cancelar" @click="$wire.set('modalRemocaoCategoria', false)" class="btn btn-primary"/>
        <x-button label="Remover" wire:click="removerCategoria" class="btn btn-error" wire:loading.attr="disabled" spinner="removerCategoria"/>
      </x-slot:actions>
    @endif
  </x-modal>
  {{-- modal para requisicao de remoção de categoria --}}

</div>
