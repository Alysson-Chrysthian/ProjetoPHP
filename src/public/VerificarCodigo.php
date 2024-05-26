<?php
    session_start();

    require_once '../App/php/helpers/helpers.php';
    require_once '../vendor/autoload.php';

    use App\User\User;
    
    if (!isset($_SESSION['criarConta']) && !isset($_SESSION['esqueciSenha'])) {
        DestruirVariaveis([
            $_SESSION['codigo'],
            $_SESSION['user']
        ]);
        header('SignUp.php');
        die();
    } else {
        $criarConta = isset($_SESSION['criarConta']);
        $esqueciSenha = isset($_SESSION['esqueciSenha']);
        $user = $_SESSION['user'];
        $cod = $_SESSION['codigo'];
        $conectado = isset($_SESSION['ManterConectado']);

        DestruirVariaveis([
            $_SESSION['criarConta'],
            $_SESSION['esqueciSenha'],
            $_SESSION['user'], 
            $_SESSION['codigo'],
            $_SESSION['ManterConectado']
        ]);
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
                    <input type="text" name="codigo" id="codigoId" placeholder="Codigo de verificação" class="input-group">
                </div>
                <div>
                    <button type="submit">
                        Enviar
                    </button>
                </div>
            </form>
            <a href="SignUp.php">Voltar</a>
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $codigo = $_POST['codigo'];
                    $codigoValidado = ValidarCodigo($codigo);

                    if ($codigoValidado && $codigo == $cod) {
                        $_SESSION['user_id'] = $user->cadastrar();
                        if ($conectado) {
                            setcookie('user_id', $_SESSION['user_id'], time() + ((3600*24)*360), '/');
                        }
                        header('location: index.php');
                        die();
                    }
                    print('<p id="erro">Codigo inserido é invalido</p>');
                }
            ?>
        </section>
    </main>
</body>
</html>