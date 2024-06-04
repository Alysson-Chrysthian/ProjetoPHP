<?php
    use App\Enums\UserAcess\UserAcess;

    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';
    require_once '../App/php/scripts/UpdateUser.php';

    $Logged = VerifyLogin();
    if (!$Logged || unserialize($_SESSION['acessType']) == UserAcess::USER_ADM) {
        header('location: SignUp.php');
        exit();
    }

    $BuyInfo = SelectAllBuysFromSpecificClient($_SESSION['user_id']);
    $User = SelectEspecificClient($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risca Faca Food Corporation</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/UserProfile.css">

    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 865px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
    <section id="UserInfo">
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
                <fieldset>
                    <legend>Informações do usuario</legend>
                    <div>
                        <label for="userId">Codigo</label>
                        <input type="text" name="userId" id="userId" value="<?php print $user['CLIENTE_ID'] ?>" readonly required>
                    </div>
                    <div>
                        <label for="userNameId">Nome</label>
                        <input type="text" name="userName" id="userNameId" value="<?php print $user['CLIENTE_NOME'] ?>" required>
                    </div>
                    <div>
                        <label for="userMailId">Email</label>
                        <input type="text" name="userMail" id="userMailId" value="<?php print $user['CLIENTE_EMAIL'] ?>" required>
                    </div>
                    <div>
                        <label for="userCpfId">Cpf</label>
                        <input type="text" name="userCpf" id="userCpfId" value="<?php print $user['CLIENTE_CPF'] ?>" required>
                    </div>
                    <div>
                        <label for="userNascId">Data de nascimento</label>
                        <input type="date" name="userNasc" id="userNascId" value="<?php print $user['CLIENTE_NASC'] ?>" required>
                    </div>
                    <div>
                        <button type="submit">
                            Alterar dados
                        </button>
                    </div>
                    <div>
                        <a href="#">Mudar Senha</a>
                        <button type="button" id="DeleteAccount" onclick="ShowPopUp('PopUpMessage')">Deletar Conta</button>
                    </div>
                    <div id="erro">
                        <?php if (isset($message)) print $message ?>
                    </div>
                </fieldset>
            </form>
            <div id="PopUpMessage">
                <p>Tem certeza de que deseja deletar sua conta?</p>
                <button type="button" onclick="ClosePopUp('PopUpMessage')">Não</button>
                <a href="DeleteAccount.php">Sim</a>
            </div>
        </section>
        <h1>Compras Realizadas</h1>
        <section id="RealizedBuys">
            <table>
                <thead>
                    <tr>
                        <th>Codigo Compra</th>
                        <th>Produto comprado</th>
                        <th>Valor da compra</th>
                        <th>Data da compra</th>
                        <th>Cancelar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($BuyInfo as $Buy) {
                        $ProductInfo = SelectEspecificProduct($Buy['COMIDA_ID']);
                    ?>
                        <tr>
                            <td><?php print $Buy['COMPRA_ID'] ?></td>
                            <td><?php print $ProductInfo['COMIDA_NOME'] ?></td>
                            <td><?php print FormatPrice($Buy['COMPRA_PREÇO']).'R$' ?></td>
                            <td><?php print $Buy['COMPRA_DATA'] ?></td>
                            <td><a href="../App/php/scripts/BuyCancel.php?id=<?php print $Buy['COMPRA_ID'] ?>">Cancelar</a></td>
                        </tr>                
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
    <script src="../App/js/ShowPopUp.js"></script>
</body>
</html>