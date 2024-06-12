<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/helpers/helpers.php';

    $error = null;
    
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>Verificar codigo</title>
    <link rel="stylesheet" href="assets/styles/android/login.css">
    <link rel="stylesheet" href="assets/styles/desktop/login.css" media="screen and (min-width: 620px)">

    <link rel="stylesheet" href="assets/styles/android/ForgotPass.css">
</head>
<body>
    <main>
        <section id="login">
            <h1>Redefinir Senha</h1>
            <form action="../App/php/scripts/ChangePassword.php" method="post">
                <div>
                    <label for="passId">Nova Senha:</label>
                    <input type="text" name="pass" id="passId" placeholder="Senha nova">
                </div>
                <div>
                    <label for="passConfirmId">Comfirmar Senha</label>
                    <input type="text" name="passConfirm" id="passConfirmId" placeholder="Confirmar senha">
                </div>
                <div>
                    <button type="submit">
                        Trocar Senha
                    </button>
                </div>
            </form>
            <p id="erro"><?php if(!empty($error)) echo $error ?></p>
        </section>
    </main>
</body>
</html>