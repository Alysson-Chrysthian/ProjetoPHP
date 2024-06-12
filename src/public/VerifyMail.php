<?php
    session_start();

    if (isset($_SESSION['erro'])) { 
        $error = $_SESSION['erro'];
        unset($_SESSION['erro']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email</title>
    <link rel="stylesheet" href="assets/styles/android/login.css">
    <link rel="stylesheet" href="assets/styles/desktop/login.css" media="screen and (min-width: 620px)">

    <link rel="stylesheet" href="assets/styles/android/ForgotPass.css">
    
</head>
<body>
    <main>
        <h1>Risca Faca</h1>
        <section id="login">
            <form action="VerifyCode.php" method="post">
                <div>
                    <label for="mailId">Digite seu email</label>
                    <input type="text" name="mail" id="mailId" placeholder="Digite o seu email">
                </div>
                <div>
                    <button type="submit">
                        Enviar Codigo
                    </button>
                </div>
            </form>
            <?php
                if (isset($error)) echo '<p id="erro">'.$error.'</p>'
            ?>
        </section>
    </main>
</body>
</html>