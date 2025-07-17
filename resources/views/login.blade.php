<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
     <div class="login-container">
        <form id="login-form">

            <img src="img/logo.png" alt="Logo Brienzex" class="login-logo">
            <h1>Bem-vindo!</h1>
            <p>Faça login para continuar.</p> 
            <div class="input-group">
                <input type="text" id="username" class="input-field" placeholder=" " required>
                <label for="username" class="input-label">Usuário</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" class="input-field" placeholder=" " required>
                <label for="password" class="input-label">Senha</label>
                <span class="password-toggle-icon" id="togglePassword"></span>
            </div>

            <button type="submit" class="login-button">Entrar</button>

            <div class="register-link">
                <p>Não tem uma conta? <a href="register.html">Cadastre-se</a></p>
            </div>
        </form>
    </div>

    <script src="login-script.js"></script>
</body>
</html>