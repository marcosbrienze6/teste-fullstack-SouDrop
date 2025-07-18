<div id="modalEditar" class="modal hidden">
  <div class="modal-content">
    <button class="close-modal" onclick="closeEditModal()">×</button>
    <h3>Editar Produto</h3>
    <form id="formEditar">
      <input type="hidden" name="id" />
      <input type="text" name="name" placeholder="Nome" required />
      <input type="text" name="description" placeholder="Descrição" />
      <input name="price" placeholder="Preço" required />
      <input type="text" name="type" placeholder="Tipo (Enum)" required />
      <input type="text" name="color" placeholder="Cor" />
      <button type="submit">Atualizar</button>
    </form>
  </div>
</div>