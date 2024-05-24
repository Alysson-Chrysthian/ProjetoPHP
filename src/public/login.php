<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/android/login.css" media="all">
    <link rel="stylesheet" href="assets/styles/desktop/login.css" media="screen and (min-width: 620px)">
    <link rel="shortcut icon" href="assets/images/favicon//RiscaFaca-Logo.jpg" type="image/x-icon">
</head>
<body>
    <main>
        <h1 id="nome-empresa">Risca faca</h1>
        <section id="background">
        </section>
        <section id="login">
            <figure>
                <img src="assets/images/content/RiscaFaca-Logo.png" alt="Logo da risca faca">
            </figure>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
                <h2>Registrar-se</h2>
                <div class="container-input">
                    <input type="text" name="name" class="input-group" placeholder="Nome">
                </div>
                <div class="container-input">
                    <input type="text" name="email" class="input-group" placeholder="Email">
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha">
                </div>
                <div class="container-input">
                    <input type="text" name="cpf" class="input-group" placeholder="Cpf">
                </div>
                <div class="container-input">
                    <input type="text" name="nascimento" class="input-group" placeholder="Nascimento">
                </div>
                <button type="submit">
                    Registrar-se
                </button>
                <a href="#">Entrar</a>
            </form>
        </section>
    </main>
</body>
</html>