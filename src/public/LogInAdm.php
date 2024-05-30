<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    use App\Class\Controller\Adm;

    $message;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $AdmInfo = [
           'id' => $_POST['adm_id'],
           'pass' => $_POST['password']
        ];

        if (IsInfoSet($AdmInfo)) {
            $Adm = new Adm($AdmInfo);

            $validate = VerifyAdm($Adm);

            if (!$validate) {
                $message = 'Informações inseridas sao invalidas';
            } else {
                $AdmId = $Adm->VerifyIfAdmExist();
                CreateAdminSession($AdmId);
            }
        } else {
            $message = 'Por favor preencha todos os campos';
        }
    }

    $Logged = VerifyLogin();
    if ($Logged) {
        header('location: index.php');
        exit();
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
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
                <h2>Entrar Admin</h2>
                <div class="container-input">
                    <input type="text" name="adm_id" class="input-group" placeholder="Codigo do adm" required>
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha" required>
                </div>
                <button type="submit">
                    Entrar
                </button>
                <a href="SignUp.php">Registrar-se</a>
                <a href="LogInUser.php">Entra como Usuario</a>
                <a href="ForgotPass.php">Esqueci Senha</a>
            </form>
            <?php if (isset($message)) print '<p id="erro">'.$message.'</p>' ?>
        </section>
    </main>
</body>
</html>