<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    use App\Class\Controller\User;

    $message;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User(
            $_POST['name'],
            $_POST['cpf'],
            $_POST['email'],
            $_POST['password'],
            $_POST['nasc']
        );

        if (!VerifyUser($user)) {
            $message = 'Usuario ja existe ou informações foram preenchidas incorretamente';
        } else {
            $id = $user->Register();
            CreateUserSession($id, isset($_POST['StillConn']));
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
    <link rel="stylesheet" href="assets/styles/android/login.css" media="all">
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
                <h2>Registrar-se</h2>
                <div class="container-input">
                    <input type="text" name="name" class="input-group" placeholder="Nome" required>
                </div>
                <div class="container-input">
                    <input type="text" name="email" class="input-group" placeholder="Email" required>
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha" required>
                </div>
                <div class="container-input">
                    <input type="text" name="cpf" class="input-group" placeholder="cpf" required>
                </div>
                <div class="container-input">
                    <input type="date" name="nasc" class="input-group" required>
                </div>
                <div>
                    <label for="StillConnId">Manter-se Conectado</label>
                    <input type="checkbox" name="StillConn" id="StillConnId">
                </div>
                <button type="submit">
                    Registrar-se
                </button>
                <a href="LogInUser.php">Entrar</a>
            </form>
            <?php if (isset($message)) print '<p id="erro">'.$message.'</p>' ?>
        </section>
    </main>
</body>
</html>