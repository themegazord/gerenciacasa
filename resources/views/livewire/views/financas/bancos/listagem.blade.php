<div class="p-4 md:p-6">
  <h1 class="text-2xl font-bold mb-6">Bancos</h1>

  <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8">
    <div class="flex-1">
      <x-input label="Pesquisa" placeholder="Nome, tipo, agência, conta..." icon="o-magnifying-glass" inline/>
    </div>
    <div class="flex items-center gap-2">
      <x-toggle id="ativo" />
      <label for="ativo" class="font-medium">Ativo?</label>
    </div>
    <div>
      <x-button label="Pesquisar" icon="o-magnifying-glass" class="btn btn-primary w-full md:w-auto" />
    </div>
    <div>
      <x-button label="Cadastrar" icon="o-plus" class="btn btn-success w-full md:w-auto" />
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

  <x-table :headers="$headers" :rows="$bancos" empty-text="Não contêm bancos cadastrados" show-empty-text with-pagination />
</div>
