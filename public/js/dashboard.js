window.produtosMap = {};
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("filterInput");
    const productList = document
        .getElementById("productList")
        .querySelector("tbody");
    let produtos = [];
    let paginaAtual = 1;
    let productToDelete = null;

    async function fetchProducts(filter = "", pagina = 1) {
        try {
            const response = await fetch(
                `/api/product/get/filter?filter=${encodeURIComponent(
                    filter
                )}&page=${pagina}`
            );
            const result = await response.json();

            if (response.ok) {
                produtos = result.product.data;
                window.produtosMap = {};
                produtos.forEach((p) => (window.produtosMap[p.id] = p));

                paginaAtual = result.product.current_page;

                renderizarProdutos(produtos);

                document.getElementById("previous").disabled =
                    !result.product.prev_page_url;
                document.getElementById("next").disabled =
                    !result.product.next_page_url;

                document.getElementById("previous").onclick = () =>
                    fetchProducts(filter, paginaAtual - 1);
                document.getElementById("next").onclick = () =>
                    fetchProducts(filter, paginaAtual + 1);
            }
        } catch (err) {
            console.error("Erro ao carregar produtos", err);
        }
    }

    function renderizarProdutos(lista) {
        productList.innerHTML = "";

        if (lista.length === 0) {
            productList.innerHTML =
                '<tr><td colspan="4">Nenhum produto encontrado.</td></tr>';
            return;
        }

        lista.forEach((prod) => {
            productList.innerHTML += `
                <tr>
                    <td>${prod.name}</td>
                    <td>R$${prod.price},00</td>
                    <td>${prod.color}</td>
                    <td>
                        <div class="action-group">
                            <button onclick='openDetailsModal(${
                                prod.id
                            })' title="Detalhes do produto">
                                <i data-lucide="eye"></i>
                            </button>

                            <button class="btn-edit" onclick='openEditModal(${JSON.stringify(
                                prod
                            )})' title="Editar">
                                <i data-lucide="edit-2"></i>
                            </button>

                            <button class="btn-delete" onclick="openDeleteModal(${
                                prod.id
                            })" title="Excluir">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        lucide.createIcons();
    }

    document.querySelector(".btn-add").addEventListener("click", () => {
        window.openModal();
    });

    document
        .getElementById("formCriar")
        .addEventListener("submit", async (e) => {
            e.preventDefault();

            const form = e.target;
            const data = {
                name: form.name.value,
                description: form.description.value,
                price: form.price.value,
                type: form.type.value,
                color: form.color.value,
            };

            try {
                const token = localStorage.getItem("token");
                const response = await fetch("/api/product/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();
                if (response.ok) {
                    form.reset();
                    closeModal();
                    fetchProducts();
                    showToast("Produto criado com sucesso");
                }
            } catch (err) {
                console.error("Erro na criação:", err);
            }
        });

    document
        .getElementById("formEditar")
        .addEventListener("submit", async (e) => {
            e.preventDefault();

            const form = e.target;
            const id = form.id.value;
            const data = {
                name: form.name.value,
                description: form.description.value,
                price: form.price.value,
                type: form.type.value,
                color: form.color.value,
            };

            try {
                const response = await fetch(`/api/product/update/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();
                if (response.ok) {
                    closeEditModal();
                    fetchProducts();
                    showToast("Produto atualizado com sucesso");
                } else {
                    showToast(result.message || "Erro ao atualizar", "error");
                }
            } catch (err) {
                console.error(err);
                showToast("Erro ao atualizar", "error");
            }
        });

    input.addEventListener("input", (e) => {
        fetchProducts(e.target.value);
    });

    fetchProducts();

    window.openModal = function () {
        document.getElementById("modalCriar").classList.remove("hidden");
    };

    window.closeModal = function () {
        document.getElementById("modalCriar").classList.add("hidden");
    };

    window.openDetailsModal = function (id) {
        const produto = window.produtosMap[id];
        if (!produto) return;

        const detalhes = `
        <p><strong>Nome:</strong> ${produto.name}</p>
        <p><strong>Descrição:</strong> ${produto.description}</p>
        <p><strong>Preço:</strong> R$ ${produto.price}</p>
        <p><strong>Tipo:</strong> ${produto.type}</p>
        <p><strong>Cor:</strong> ${produto.color}</p>
    `;
        document.getElementById("detalhesConteudo").innerHTML = detalhes;
        document.getElementById("modalDetalhes").classList.remove("hidden");
    };

    window.closeDetailsModal = function () {
        document.getElementById("modalDetalhes").classList.add("hidden");
    };

    window.openEditModal = function (produto) {
        const form = document.getElementById("formEditar");
        form.id.value = produto.id;
        form.name.value = produto.name;
        form.description.value = produto.description;
        form.price.value = produto.price;
        form.type.value = produto.type;
        form.color.value = produto.color;

        document.getElementById("modalEditar").classList.remove("hidden");
    };

    window.closeEditModal = function () {
        document.getElementById("modalEditar").classList.add("hidden");
    };

    window.openDeleteModal = function (id) {
        productToDelete = id;
        document
            .getElementById("confirmDeleteModal")
            .classList.remove("hidden");
    };

    window.closeDeleteModal = function () {
        document.getElementById("confirmDeleteModal").classList.add("hidden");
        productToDelete = null;
    };

    window.confirmarExclusao = function () {
        if (!productToDelete) return;

        fetch(`/api/product/delete/${productToDelete}`, {
            method: "DELETE",
            headers: { Accept: "application/json" },
        })
            .then((res) => res.json())
            .then(() => {
                showToast("Produto excluído com sucesso");
                closeDeleteModal();
                fetchProducts();
            })
            .catch((err) => {
                showToast("Erro ao excluir", "error");
                console.error(err);
            });
    };

    window.showToast = function (message, type = "success") {
        const toast = document.createElement("div");
        toast.className = "toast";

        if (type === "error") {
            toast.style.backgroundColor = "#e74c3c";
        }

        toast.innerText = message;
        document.getElementById("toast-container").appendChild(toast);

        setTimeout(() => toast.remove(), 4000);
    };

    window.toggleChatbot = function () {
        document.getElementById("chatbotWindow").classList.toggle("hidden");
    };

    window.sendMessage = async function () {
        const input = document.getElementById("chatInput");
        const mensagem = input.value.trim();
        const body = document.getElementById("chatbotBody");

        if (!mensagem) return;

        const userMsg = document.createElement("div");
        userMsg.className = "chat-message user";
        userMsg.innerText = mensagem;
        body.appendChild(userMsg);

        input.value = "";

        const botMsg = document.createElement("div");
        botMsg.className = "chat-message bot";
        botMsg.innerText = "Pensando...";
        body.appendChild(botMsg);

        body.scrollTop = body.scrollHeight;

        try {
            const response = await fetch("/api/product/groq", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ prompt: mensagem }),
            });

            const result = await response.json();
            botMsg.innerText = result.resposta || "[Erro ao obter resposta]";
        } catch (error) {
            console.error("Erro na requisição:", error);
            botMsg.innerText = "[Erro de conexão]";
        }

        body.scrollTop = body.scrollHeight;
    };
});
