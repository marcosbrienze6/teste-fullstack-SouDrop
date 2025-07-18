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