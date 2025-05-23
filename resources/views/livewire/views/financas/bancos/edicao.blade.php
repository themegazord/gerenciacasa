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
@endphp
<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Edição de bancos</h1>
  <x-form wire:submit.prevent="editar" class="flex flex-col gap-4">
    <div class="flex flex-col md:grid md:grid-cols-5 md:items-end gap-4">
      <div class="col-span-3">
        <x-input label="Nome do banco" placeholder="Insira o nome do banco..." wire:model.fill="banco.nome" value="{{ $bancoAtual->nome }}" inline/>
      </div>
      <div class="col-span-1">
        <x-select label="Tipo do banco" wire:model="banco.tipo" :options="$tiposBancos" option-value="tipo" inline option-label="label" placeholder="Selecione o tipo do banco..."/>
      </div>
      <x-toggle label="Ativo?" wire:model="banco.ativo" box-class="col-span-1"/>
    </div>
    <div class="flex flex-col md:grid md:grid-cols-2 md:items-end gap-4">
      <div class="col-span-1">
        <x-input label="Saldo inicial" wire:model="banco.saldo_inicial" prefix="R$" locale="pt-BR" money inline/>
      </div>
      <div class="col-span-1">
        <x-input label="Saldo atual" wire:model="banco.saldo_atual" prefix="R$" locale="pt-BR" money inline/>
      </div>
    </div>
    <div class="flex flex-col md:grid md:grid-cols-2 md:items-end gap-4">
      <div class="col-span-1">
        <x-input label="Agência" wire:model.fill="banco.agencia" value="{{ $bancoAtual->agencia }}" placeholder="Insira o número da agência..." inline/>
      </div>
      <div class="col-span-1">
        <x-input label="Conta" wire:model.fill="banco.numero_conta" value="{{ $bancoAtual->numero_conta }}" placeholder="Insira o número da conta..." inline/>
      </div>
    </div>
    <x-textarea rows="5" wire:model.fill="banco.descricao" value="{{ $bancoAtual->descricao }}" label="Descrição" placeholder="Insira uma descrição do banco..." inline />
    <x-slot:actions>
      <x-button label="Cancelar" class="btn btn-error" link="{{ route('financas.bancos.listagem') }}" wire:loading.attr="disabled"/>
      <x-button type="submit" label="Salvar" class="btn btn-success" wire:loading.attr="disabled" spinner="editar"/>
    </x-slot:actions>
  </x-form>
</div>
