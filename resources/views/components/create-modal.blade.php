   <div id="modalCriar" class="modal hidden">
     <div class="modal-content">
        <button class="close-modal" onclick="closeModal()">×</button>
     <h3>Adicionar Produto</h3>
        <form id="formCriar">
        <input type="text" name="name" placeholder="Nome" required />
        <input type="text" name="description" placeholder="Descrição" />
        <input type="number" name="price" placeholder="Preço" required />
        <input type="text" name="type" placeholder="Tipo (Enum)" required />
        <input type="text" name="color" placeholder="Cor" />
        <button type="submit">Criar</button>
        </form>
     </div>
    </div>