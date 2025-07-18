<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | SouDrop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/lucide@latest"></script>
  
  <link rel="stylesheet" href="{{asset('/css/dashboard.css')}}" />
  <link rel="stylesheet" href="{{asset('/css/modals.css')}}" />

</head>
<body>
  <header>
    <div class="head_left">
     <a href="/api/home"><h2>SouDrop</h2></a>
    </div>
  </header>

  <div class="dashboard-container">
  <div class="dashboard-top-bar">
      <h2>Minha Dashboard</h2>
      <button class="btn-add" onclick="openModal()">+ Adicionar Produto</button>
  </div>

  <div class="filter-bar">
    <input type="text" id="filterInput" placeholder="Buscar produto pelo nome...">
  </div>

  <table id="productList" class="product-list">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Cor</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

  {{-- Modal para adicionar produtos --}}
  @include('components.create-modal')
    
  {{-- Modal para visualizar detalhes --}}
  @include('components.details-modal')


  <div id="paginate">
      <button class="paginate-btn" id="previous">Anterior</button>
      <button class="paginate-btn" id="next">Próximo</button>
  </div>
  </div>

  <!-- Modal do ChatBot -->
  @include('components.chatbot')

  <div id="toast-container" class="toast-container"></div>

  <!-- Modal de Edição -->
  @include('components.edit-modal')

  <!-- Modal de Confirmação de Exclusão -->
  @include('components.delete-modal')

  <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>