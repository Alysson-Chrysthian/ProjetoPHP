<?php
    session_start();
    
    require_once '../vendor/autoload.php';
    require_once '../App/php/helpers/helpers.php';
    
    use App\Mail\Mail;
    use App\User\User;
    
    VerificarLogin();
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
                    <input type="text" name="name" class="input-group" placeholder="Nome">
                </div>
                <div class="container-input">
                    <input type="text" name="email" class="input-group" placeholder="Email">
                </div>
                <div class="container-input">
                    <input type="text" name="password" class="input-group" placeholder="Senha">
                </div>
                <div class="container-input">
                    <input type="text" name="cpf" class="input-group" placeholder="cpf xxx.xxx.xxx-xx">
                </div>
                <div class="container-input">
                    <input type="text" name="nascimento" class="input-group" placeholder="data xx/xx/xxxx">
                </div>
                <div>
                    <label for="ManterConectadoId">Manter-se Conectado</label>
                    <input type="checkbox" name="ManterConectado" id="ManterConectadoId">
                </div>
                <button type="submit">
                    Registrar-se
                </button>
                <a href="#">Entrar</a>
            </form>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nome = $_POST['name'];
                    $email = $_POST['email'];
                    $senha = $_POST['password'];
                    $cpf = $_POST['cpf'];
                    $nasc = $_POST['nascimento'];

                    $user = new User($nome, $email, $cpf, $senha, $nasc);

                    $validado = $user->ValidarInfo();

                    if ($validado) {
                        $_SESSION['codigo'] = Mail::EnviarEmail($email);
                        $_SESSION['criarConta'] = true;
                        $_SESSION['user'] = $user;

                        if (isset($_POST['ManterConectado'])) {
                            $_SESSION['ManterConectado'] = true;
                        }

                        header('location: VerificarCodigo.php');
                        die();
                    } else {
                        print '<p id="erro">Não foi possivel realizar o cadastro</p>';
                    }
                }

            ?>
        </section>
    </main>
</body>
</html>