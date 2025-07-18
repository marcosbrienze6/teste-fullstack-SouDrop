<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | SouDrop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://unpkg.com/lucide@latest"></script>
  
  <link rel="stylesheet" href="{{asset('/css/dashboard.css')}}" />

</head>
<body>
  <header>
    <div class="head_left">
      <h2>SouDrop</h2>
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
    <div id="modalCriar" class="modal hidden">
     <div class="modal-content">
        <button class="close-modal" onclick="closeModal()">×</button>
     <h3>Adicionar Produto</h3>
        <form id="formCriar">
        <input type="text" name="name" placeholder="Nome" required />
        <input type="text" name="description" placeholder="Descrição" />
        <input name="price" placeholder="Preço" required />
        <input type="text" name="type" placeholder="Tipo (Enum)" required />
        <input type="text" name="color" placeholder="Cor" />
        <button type="submit">Criar</button>
        </form>
     </div>
    </div>
    
    {{-- Modal para visualizar detalhes --}}
    <div id="modalDetalhes" class="modal hidden">
    <div class="modal-content">
        <button class="close-modal" onclick="fecharModalDetalhes()">×</button>
        <h3>Detalhes do Produto</h3>
        <div id="detalhesConteudo"></div>
    </div>
    </div>

    <div id="paginate">
        <button class="paginate-btn" id="previous">Anterior</button>
        <button class="paginate-btn" id="next">Próximo</button>
    </div>
  </div>

  <div class="wrapper">
    <footer class="footer">
    <div class="footer-content">
        <p>&copy; 2025 SouDrop. Todos os direitos reservados.</p>
        <ul class="footer-links">
        <li><a href="#">Termos de uso</a></li>
        <li><a href="#">Política de privacidade</a></li>
        <li><a href="#">Contato</a></li>
        </ul>
    </div>
    </footer>
  </div>

  <script>
  const input = document.getElementById('filterInput');
  const productList = document.getElementById('productList').querySelector('tbody');
  let produtos = [];
  let paginaAtual = 1;

  async function fetchProducts(filter = '', pagina = 1) {
    try {
      const response = await fetch(`/api/product/get/filter?filter=${encodeURIComponent(filter)}&page=${pagina}`);
      const result = await response.json();
      console.log(result);

      if (response.ok) {
        produtos = result.product.data;
        paginaAtual = result.product.current_page;

        renderizarProdutos(produtos);

        document.getElementById('previous').disabled = !result.product.prev_page_url;
        document.getElementById('next').disabled = !result.product.next_page_url;

        document.getElementById('previous').onclick = () => fetchProducts(filter, paginaAtual - 1);
        document.getElementById('next').onclick = () => fetchProducts(filter, paginaAtual + 1);
      }
    } catch (err) {
      console.error('Erro ao carregar produtos', err);
    }
  }

  function openModal() {
      document.getElementById('modalCriar').classList.remove('hidden');
  }

  function closeModal() {
      document.getElementById('modalCriar').classList.add('hidden');
  }

  function abrirModalDetalhes(produto) {
  const detalhes = `
    <p><strong>Nome:</strong> ${produto.name}</p>
    <p><strong>Descrição:</strong> ${produto.description}</p>
    <p><strong>Preço:</strong> R$ ${produto.price}</p>
    <p><strong>Tipo:</strong> ${produto.type}</p>
    <p><strong>Cor:</strong> ${produto.color}</p>
    <p><strong>Dono:</strong> ${produto.user?.name ?? 'Desconhecido'} (${produto.user?.email ?? ''})</p>
  `;

  document.getElementById('detalhesConteudo').innerHTML = detalhes;
  document.getElementById('modalDetalhes').classList.remove('hidden');
}

    function fecharModalDetalhes() {
    document.getElementById('modalDetalhes').classList.add('hidden');
    }

  function renderizarProdutos(lista) {
    productList.innerHTML = '';

    if (lista.length === 0) {
      productList.innerHTML = '<tr><td colspan="4">Nenhum produto encontrado.</td></tr>';
      return;
    }

    lista.forEach((prod, index) => {
      productList.innerHTML += `
         <tr>
            <td>${prod.name}</td>
            <td>R$${prod.price},00</td>
            <td>${prod.color}</td>
            <td>
            <div class="action-group">
                <button onclick='abrirModalDetalhes(${JSON.stringify(prod)})' title="Detalhes do produto">
                    <i data-lucide="eye"></i>
                </button>

                <button class="btn-edit" onclick="atualizarProduto(${prod.id})" title="Editar">
                    <i data-lucide="edit-2"></i>
                </button>

                <button class="btn-delete" onclick="deletarProduto(${prod.id})" title="Excluir">
                    <i data-lucide="trash-2"></i>
                </button>
            </div>
            </td>
        </tr>
      `;
      lucide.createIcons()
    });
  }

    document.querySelector('.btn-add').addEventListener('click', () => {
    document.getElementById('modalCriar').classList.remove('hidden');
    });

    document.getElementById('formCriar').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const data = {
        name: form.name.value,
        description: form.description.value,
        price: form.price.value,
        type: form.type.value,
        color: form.color.value
    };

    try {
        const token = localStorage.getItem('token');
        const response = await fetch('/api/product/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(data)
        });

        const result = await response.json();
        if (response.ok) {
        alert('Produto criado com sucesso!');
        document.getElementById('modalCriar').classList.add('hidden');
        fetchProducts(); 
        }  {
        alert(result.message || 'Erro ao criar produto');
        }

    } catch (err) {
        console.error('Erro na criação:', err);
    }
    });

  function atualizarProduto(id) {
    const novoNome = prompt('Digite o novo nome do produto:');
    if (!novoNome) return;

    fetch(`/api/product/update/${id}`, {
        method: 'PUT',
        headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
        },
        body: JSON.stringify({ name: novoNome })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'Produto atualizado');
        fetchProducts();
    })
    .catch(err => {
        alert('Erro ao atualizar');
        console.error(err);
    });
  }

  function deletarProduto(id) {
    if (!confirm('Tem certeza que deseja excluir este produto?')) return;

    fetch(`/api/product/delete/${id}`, {
        method: 'DELETE',
        headers: {
        'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || 'Produto excluído');
        fetchProducts(); 
    })
    .catch(err => {
        alert('Erro ao excluir');
        console.error(err);
    });
  }

  input.addEventListener('input', (e) => {
    fetchProducts(e.target.value);
  });

  fetchProducts();

function toggleChatbot() {
  const chat = document.getElementById('chatbotWindow');
  chat.classList.toggle('hidden');
}

async function sendMessage() {
  const input = document.getElementById('chatInput');
  const mensagem = input.value.trim();
  const body = document.getElementById('chatbotBody');

  if (!mensagem) return;

  const userMsg = document.createElement('div');
  userMsg.className = 'chat-message user';
  userMsg.innerText = mensagem;
  body.appendChild(userMsg);

  input.value = '';

  const botMsg = document.createElement('div');
  botMsg.className = 'chat-message bot';
  botMsg.innerText = 'Pensando...';
  body.appendChild(botMsg);

  body.scrollTop = body.scrollHeight;

  try {
    const response = await fetch('/api/product/groq', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ prompt: mensagem })
    });

    const result = await response.json();

    botMsg.innerText = result.resposta || '[Erro ao obter resposta]';

  } catch (error) {
    console.error('Erro na requisição:', error);
    botMsg.innerText = '[Erro de conexão]';
  }

  body.scrollTop = body.scrollHeight;
}
</script>

<div class="chatbot-container">
  <button class="chatbot-toggle" onclick="toggleChatbot()">
    <i data-lucide="message-circle"></i>
  </button>

  <div class="chatbot-window hidden" id="chatbotWindow">
    <div class="chatbot-header">
      <span>Assistente Virtual</span>
      <button onclick="toggleChatbot()">✖</button>
    </div>
    <div class="chatbot-body" id="chatbotBody">
      <div class="chat-message bot">Olá! Em que posso ajudar?</div>
    </div>
    <div class="chatbot-input">
      <input type="text" placeholder="Digite sua mensagem..." id="chatInput" />
      <button onclick="sendMessage()">Enviar</button>
    </div>
  </div>
</div>

</body>
</html>