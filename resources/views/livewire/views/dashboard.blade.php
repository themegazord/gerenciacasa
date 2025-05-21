<div class="p-6">

  <!-- Dashboard -->
  <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

  <!-- Cards Resumo -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Saldo Atual</h2>
        <p class="text-2xl font-semibold text-green-500">R$ 3.250,00</p>
      </div>
    </div>
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Receitas do Mês</h2>
        <p class="text-2xl font-semibold text-blue-500">R$ 5.000,00</p>
      </div>
    </div>
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Despesas do Mês</h2>
        <p class="text-2xl font-semibold text-red-500">R$ 1.750,00</p>
      </div>
    </div>
  </div>

  <!-- Gastos por categoria (simulado) -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Gastos por Categoria</h2>
        <ul class="text-sm">
          <li class="flex justify-between border-b py-1"><span>Alimentação</span><span>R$ 500,00</span></li>
          <li class="flex justify-between border-b py-1"><span>Transporte</span><span>R$ 300,00</span></li>
          <li class="flex justify-between border-b py-1"><span>Lazer</span><span>R$ 250,00</span></li>
          <li class="flex justify-between border-b py-1"><span>Saúde</span><span>R$ 200,00</span></li>
        </ul>
      </div>
    </div>

    <!-- Contas a pagar -->
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title">Contas a Pagar</h2>
        <ul class="text-sm">
          <li class="flex justify-between border-b py-1"><span>Energia</span><span>20/05 - R$ 180,00</span></li>
          <li class="flex justify-between border-b py-1"><span>Internet</span><span>22/05 - R$ 120,00</span></li>
          <li class="flex justify-between border-b py-1"><span>Cartão</span><span>25/05 - R$ 450,00</span></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Histórico recente -->
  <div class="card bg-base-100 shadow mb-8">
    <div class="card-body">
      <h2 class="card-title">Histórico Recente</h2>
      <div class="overflow-x-auto">
        <table class="table table-zebra w-full text-sm">
          <thead>
            <tr>
              <th>Data</th>
              <th>Descrição</th>
              <th>Categoria</th>
              <th class="text-right">Valor</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>18/05</td>
              <td>Salário</td>
              <td>Receita</td>
              <td class="text-right text-green-500">+ R$ 5.000,00</td>
            </tr>
            <tr>
              <td>19/05</td>
              <td>Supermercado</td>
              <td>Alimentação</td>
              <td class="text-right text-red-500">- R$ 200,00</td>
            </tr>
            <tr>
              <td>20/05</td>
              <td>Uber</td>
              <td>Transporte</td>
              <td class="text-right text-red-500">- R$ 50,00</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Metas e progresso (simulado) -->
  <div class="card bg-base-100 shadow">
    <div class="card-body">
      <h2 class="card-title">Meta de Economia</h2>
      <p class="text-sm mb-2">Economizar R$ 1.000 até o fim do mês</p>
      <progress class="progress progress-success w-full" value="325" max="1000"></progress>
      <p class="text-xs text-right mt-1">R$ 325,00 economizados</p>
    </div>
  </div>
</div>
