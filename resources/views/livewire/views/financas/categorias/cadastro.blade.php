@php
$tiposCategorias = [
  ['id' => 'receita', 'name' => 'Receitas'],
  ['id' => 'despesa', 'name' => 'Despesas'],
];
@endphp
<div class="p-4 md:p-6">
  <div class="font-semibold text-xl mb-8">Cadastro de categorias</div>
  <x-form wire:submit.prevent="cadastrar">
    <x-input label="Nome da categoria" placeholder="Informe o nome da categoria..." wire:model="categoria.nome" inline />
    <div class="flex flex-col md:flex-row gap-4 mt-4">
      <div class="flex-1">
        <x-select label="Tipo da categoria" placeholder="Escolha o tipo..." placeholder-value="{{ null }}" wire:model="categoria.tipo" :options="$tiposCategorias" inline />
      </div>
      <div class="flex-1">
        <x-colorpicker wire:model="categoria.cor" label="Cor da categoria" placeholder="Cor da tag..." inline />
      </div>
    </div>

    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-error" link="{{ route('financas.categorias.listagem') }}"/>
      <x-button label="Cadastrar" class="btn btn-success" type="submit" wire:loading.attr="disabled" spinner="cadastrar"/>
    </x-slot:actions>
  </x-form>
</div>
