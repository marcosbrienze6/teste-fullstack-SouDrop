<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('/css/home.css')}}" />
    <title>SouDrop</title>
</head>
<body>
    <header>
        <div class="head_left">
            <h2>SouDrop</h2>
        </div>

        <div class="head_right">
            <a href="/api/register">
                <button>Criar conta</button>
            </a>
            <a href="/api/login">
                <button class="login_button">Entrar</button>
            </a>
        </div>
    </header>

    <div class="message">
      <h2>Seja bem-vindo à SouDrop!</h2>
      <p>Monte seu ecommerce de forma inteligente e ágil</p>
    </div>

    <section class="start-here" id="start-section">

        <div class="card">
            <div class="card-number">1</div>
            <h3>Cadastre-se como vendedor</h3>
            <p>Crie sua conta e comece a montar sua loja online em poucos minutos.</p>
            <a href="/api/register"><button class="card-button">Quero vender</button></a>
        </div>

        <div class="card">
            <div class="card-number">2</div>
            <h3>Adicione seus produtos</h3>
            <p>Cadastre seus itens com fotos, preços e descrições atrativas.</p>
            <a href="/api/register"><button class="card-button">Começar cadastro</button></a>
        </div>

        <div class="card">
            <div class="card-number">3</div>
            <h3>Venda e receba</h3>
            <p>Receba pedidos, envie para os clientes e acompanhe seus ganhos em tempo real.</p>
            <button class="card-button">Veja como funciona</button>
        </div>

    </section>
</body>
</html>