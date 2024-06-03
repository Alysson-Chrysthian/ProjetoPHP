<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

    $Logged = VerifyLogin();
    if (!$Logged) {
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
        <section id="UserInfo">
            <form action="" method="post">
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
                        <input type="text" name="userNasc" id="userNascId" value="<?php print $user['CLIENTE_NASC'] ?>" required>
                    </div>
                    <div>
                        <button type="submit">
                            Alterar dados
                        </button>
                    </div>
                    <div>
                        <a href="#">Mudar Senha</a>
                        <a href="#">Deletar Conta</a>
                    </div>
                </fieldset>
            </form>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
</body>
</html>