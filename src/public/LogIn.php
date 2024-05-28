<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

    $Logged = VerifyLogin();
    if ($Logged) {
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/android/login.css" media="all">>
    <link rel="stylesheet" href="assets/styles/desktop/login.css" media="screen and (min-width: 620px)">
    <link rel="shortcut icon" href="assets/images/favicon/favicon-login.png" type="image/x-icon">
</head>
<body>
    <main>
        <h1 id="nome-empresa">Risca faca</h1>
        <section id="background">
        </section>
        <section id="login">
            <figure>
                <img src="assets/images/figures/RiscaFaca-Logo.png" alt="Logo da risca faca">
            </figure>
            <form action="../App/php/scripts/LogUser.php" method="post">
                <h2>Entrar</h2>
                <div class="container-input">
                    <input type="text" name="email" class="input-group" placeholder="Email">
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha">
                </div>
                <div>
                    <label for="StillConnId">Manter-se Conectado</label>
                    <input type="checkbox" name="StillConn" id="StillConnId">
                </div>
                <button type="submit">
                    Entrar
                </button>
                <a href="SignUp.php">Registrar-se</a>
                <a href="">Entra como administrador</a>
                <a href="EsqueciSenha.php">Esqueci Senha</a>
            </form>
            <?php VerifyError() ?>
        </section>
    </main>
</body>
</html>