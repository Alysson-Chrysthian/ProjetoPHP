<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/helpers/helpers.php';

    session_start();

    use App\Class\Mail\Mail;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = CreateVerifyCode();

        $_SESSION['code'] = $code;

        $mail = new Mail();
        $mail->sendMail($code, $_POST['mail']);
    } else {
        header('location: VerifyMail.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar codigo</title>
    <link rel="stylesheet" href="assets/styles/android/login.css">
    <link rel="stylesheet" href="assets/styles/desktop/login.css" media="screen and (min-width: 620px)">

    <link rel="stylesheet" href="assets/styles/android/ForgotPass.css">
</head>
<body>
    <main>
        <h1>Risca Faca</h1>
        <section id="login">
            <form action="../App/php/scripts/VerifyCode.php" method="post">
                <div>
                    <label for="codeId">o código foi enviado no email: <span><?php print $_POST['mail'] ?></span></label>
                    <input type="text" name="code" id="codeId" placeholder="Digite o seu codigo">
                </div>
                <div>
                    <button type="submit">
                        Enviar Codigo
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>