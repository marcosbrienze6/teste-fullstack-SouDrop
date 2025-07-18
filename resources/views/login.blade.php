<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Entrar - SouDrop</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{asset('/css/login.css')}}" />

</head>
<body>
    <form id="login_container">
        <h1>Entrar</h1>

        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>

        <span>Não tem uma conta?</span><a href="/api/register"> Crie uma !</a><br><br>
        <button type="submit">Entrar</button>
    </form>

  <p id="mensagem" style="color: red;"></p>

  <script>
    const form = document.getElementById('login_container');
    const mensagem = document.getElementById('mensagem');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const data = {
        email: form.email.value,
        password: form.password.value,
      };

      try {
        const response = await fetch('/api/auth/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        console.log('teste');
        const result = await response.json();

        if (response.ok) {
          localStorage.setItem('token', result.token);
          window.location.href = '/api/dashboard'; 
        } {
          mensagem.textContent = result.message || 'Erro ao fazer login.';
        }

      } catch (err) {
        mensagem.textContent = 'Erro de conexão com o servidor.';
      }
    });
  </script>

</body>
</html>
