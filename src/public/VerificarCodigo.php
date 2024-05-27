<?php
    use App\User\User;
    use App\Mail\Mail;

    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    $redirectPage = 'SignUp.php';

    if (isset($_POST['code'])) {
        $codeVerified = VerifyCode($_POST['code'], $_SESSION['VerifyCode']);
        
        if ($codeVerified) {
            $_SESSION['user_id'] = unserialize($_SESSION['user'])->RegisterUser();
            if ($_SESSION['StillConn']) {
                CreateUserIdCookie($_SESSION['user_id']);
            }
            UnsetVariables([
                $_SESSION['StillConn'],
                $_SESSION['user'],
                $_SESSION['VerifyCode']
            ]);
            header('location: '.$redirectPage);
            exit();
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['name'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $pass = $_POST['password'];
        $nasc = $_POST['nasc'];

        $user = new User($nome, $cpf, $email, $pass, $nasc);
        $userValidate = $user->ValidateInfo();

        if (!$userValidate) {
            $_SESSION['erro'] = true;
            header('location: '.$redirectPage);
            exit();
        }

        $_SESSION['user'] = serialize($user);
        $_SESSION['StillConn'] = isset($_POST['StillConn']);
        $_SESSION['VerifyCode'] = GenerateVerifyCode();

        $mail = new Mail();
        $mail->sendMail($_SESSION['VerifyCode'], $email);
    } else {
        header('location: '.$redirectPage);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Codigo</title>
    <link rel="stylesheet" href="assets/styles/android/VerificarCodigo.css">
</head>
<body>
    <main>
        <section>
            <figure>
                <img src="assets/images/figures/RiscaFaca-Logo.png" alt="Logo da risca faca">
            </figure>    
            <h1>Verificar Codigo</h1>
            <p>Insira no campo abaixo o <strong>codigo de verificação</strong> que foi enviado em seu email</p>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>"  method="post">
                <div class="container-input">
                    <input type="text" name="code" id="codeId" placeholder="Codigo de verificação" class="input-group">
                </div>
                <div>
                    <button type="submit">
                        Enviar
                    </button>
                </div>
                <a href="SignUp.php">Voltar</a>
            </form>
        </section>
    </main>
</body>
</html>