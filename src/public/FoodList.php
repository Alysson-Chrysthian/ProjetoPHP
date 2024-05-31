<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/helpers/helpers.php';

    use App\Enums\UserAcess\UserAcess;

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
        exit();
    }

    if (unserialize($_SESSION['acessType']) != UserAcess::USER_ADM) {
        header('location: index.php');
        exit();
    }
                        
    $products = SelectAllProducts();

    $PdrRegis = count($products);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de produtos</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/style.css">
    <link rel="stylesheet" href="assets/styles/android/ProductList.css">
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 750px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
        <section>
            <?php 
            if ($PdrRegis > 0) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Data</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $pdr) {
                        $pdr['COMIDA_PRECO'] = FormatPrice($pdr['COMIDA_PRECO']).'R$';

                        print '<tr>';
                    ?>
                        <td><?php print $pdr['COMIDA_ID'] ?></td>
                        <td> <img src="../App/php/scripts/ShowImage.php?id=<?php print $pdr['IMAGEM_ID'] ?>" alt=""> </td>
                        <td><?php print $pdr['COMIDA_NOME'] ?></td>
                        <td><?php print $pdr['COMIDA_CAT'] ?></td>
                        <td><?php print $pdr['COMIDA_DESC'] ?></td>
                        <td><?php print $pdr['COMIDA_PRECO'] ?></td>
                        <td><?php print $pdr['COMIDA_DATA'] ?></td>
                        <td class="botoes">
                            <?php
                            if ($_SESSION['user_id'] == $pdr['ADM_ID']) {
                            ?>
                                <a href="AlterProduct.php?id=<?php print $pdr['COMIDA_ID'] ?>">
                                    <img src="assets/images/figures/alterar.png" alt="alterar">
                                </a>
                            <?php
                            } else {
                            ?>
                                <span id="message">Você nao cadastrou esse produto</span>
                            <?php 
                            }
                            ?>
                        </td>
                        <td class="botoes">
                            <?php
                            if ($_SESSION['user_id'] == $pdr['ADM_ID']) {
                            ?>
                            <a href="../App/php/scripts/DeleteProducts.php?id=<?php print $pdr['COMIDA_ID'] ?>">
                                <img src="assets/images/figures/excluir.png" alt="excluir">
                            </a>
                            <?php
                            } else {
                            ?>
                                <span id="message">Você nao cadastrou esse produto</span>
                            <?php
                            }
                            ?>
                        </td>
                    <?php
                        print '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
            } else {
                print '<p id="NoProducts">Nenhum produto cadastrado até o momento</p>';
            }
            ?>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
    <script src="../App/js/Menu.js"></script>
</body>
</html>