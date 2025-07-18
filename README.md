# 🛠️ Teste FullStack SouDrop

Um painel administrativo completo com assistente virtual integrado via API da Groq. Desenvolvido com Laravel 12, JavaScript puro e arquitetura MVC.

---

## 📌 Descrição

Este projeto é um sistema **back-office** para gerenciamento de produtos, com um **assistente virtual** integrado para auxiliar nas interações, alimentado por inteligência artificial via **Groq API**. Possui interface simples, suporte a CRUD, paginação, modais dinâmicos e filtro em tempo real.

---

## 🚀 Tecnologias Utilizadas

- PHP 8.x com **Laravel 12.x**
- **JavaScript puro (ES6+)**
- **Blade Templates**
- **MySQL**
- Arquitetura **MVC**
- API externa **Groq (OpenAI compatível)**

---

## ✅ Status

✔️ Projeto finalizado e funcional  
🔒 Não possui deploy público (apenas uso local)

---

## 📂 Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/    # Controladores Laravel
│   ├── Models/              # Modelos Eloquent
├── public/
│   ├── css/                 # Estilos personalizados
│   └── js/                  # Scripts separados por função
├── resources/views/         # Views Blade (Dashboard, Modais)
├── routes/web.php           # Rotas web
├── routes/api.php           # Rotas da API REST
├── database/
│   └── migrations/          # Estrutura das tabelas
├── .env                     # Configuração do ambiente
└── README.md
```

---

## 💻 Como rodar localmente

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/seu-repositorio.git

# Acesse a pasta
cd seu-repositorio

# Instale as dependências do Laravel
composer install

# Instale dependências JS (se usar Vite/NPM - opcional)
npm install && npm run dev

# Configure o .env
cp .env.example .env
php artisan key:generate

# Configure o banco de dados no .env e rode as migrations
php artisan migrate

# Rode o servidor local
php artisan serve
```

---

## 📑 Funcionalidades Técnicas

- 🔍 **Filtro de produtos** por nome com debounce em tempo real
- 🧾 **CRUD completo** (Create, Read, Update, Delete) via API
- 📄 **Modais reutilizáveis** (Criar, Editar, Detalhar, Excluir)
- 🧠 **Integração com Groq API** (assistente virtual no painel)
- 🔄 **Paginação dinâmica**
- 🧱 **Estrutura 100% componentizada** (JS, CSS, Blade separados)
- 🔐 **Token de autenticação armazenado via LocalStorage**
- 📦 **Toast de feedback para todas ações assíncronas**
- 📁 Separação entre lógica de back e front clara (MVC)

---

## 📡 Rotas de API (principais)

| Método | Rota                       | Descrição                 |
| ------ | -------------------------- | ------------------------- |
| GET    | `/api/product/get/filter`  | Lista e filtra produtos   |
| POST   | `/api/product/store`       | Cria novo produto         |
| PUT    | `/api/product/update/{id}` | Atualiza um produto       |
| DELETE | `/api/product/delete/{id}` | Exclui um produto         |
| POST   | `/api/product/groq`        | Envia prompt à IA da Groq |

---

## 📜 Licença

MIT - sinta-se livre para usar, estudar e modificar.

---

## 🤖 Créditos

Marcos Miguel Brienze
