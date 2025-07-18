<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - SouDrop</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{asset('/css/login.css')}}" />

</head>
<body>

  <div class="card">
    <form id="login_container">
        <h1>Cadastre-se</h1>

        <input type="name" name="name" placeholder="Nome" required><br>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>

        <span>Já tem uma conta?</span><a href="/api/login"> Entre !</a><br><br>
        <button type="submit">Criar conta</button>
    </form>

     <p id="mensagem" class="mensagem-feedback"></p>
  </div>


  <script>
    const form = document.getElementById('login_container');
    const mensagem = document.getElementById('mensagem');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const data = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value,
      };

      try {
        const response = await fetch('/api/users/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        console.log(result);

        if (response.ok) {
          localStorage.setItem('token', result.token);
          window.location.href = '/api/dashboard'; 
        } {
          mensagem.textContent = result.message || 'Erro ao criar uma conta.';
        }

      } catch (err) {
        mensagem.textContent = 'Erro de conexão com o servidor.';
      }
    });
  </script>

</body>
</html>
