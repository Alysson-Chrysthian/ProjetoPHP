<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    use App\Class\Controller\User;
    
    $message;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $UserInfo = [
            'name' => $_POST['user'],
            'cpf' => '',
            'mail' => $_POST['user'],
            'pass' => $_POST['password'],
            'nasc' => ''
        ];

        if (!empty($_POST['user']) && !empty($_POST['password'])) {

            $user = new User($UserInfo);

            $UserLog = $user->VerifyIfCanLog();
            
            if (!$UserLog) {
                $message = 'Usuario não existe';
            } else {
                CreateUserSession($UserLog, isset($_POST['StillConn']));
            }
        } else {
            $message = 'Por favor insira tudo q se pede';
        }
    }

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
        <section id="login">
            <figure>
                <img src="assets/images/figures/RiscaFaca-Logo.png" alt="Logo da risca faca">
            </figure>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
                <h2>Entrar</h2>
                <div class="container-input">
                    <input type="text" name="user" class="input-group" placeholder="Email ou Usuario" required>
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha" required>
                </div>
                <div>
                    <label for="StillConnId">Manter-se Conectado</label>
                    <input type="checkbox" name="StillConn" id="StillConnId">
                </div>
                <button type="submit">
                    Entrar
                </button>
                <a href="SignUp.php">Registrar-se</a>
                <a href="LogInAdm.php">Entra como administrador</a>
                <a href="ForgotPass.php">Esqueci Senha</a>
            </form>
            <?php if (isset($message)) print '<p id="erro">'.$message.'</p>' ?>
        </section>
    </main>
</body>
</html>