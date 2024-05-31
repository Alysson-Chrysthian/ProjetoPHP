<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risca Faca Food Corporation</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/style.css">
    <link rel="stylesheet" href="assets/styles/android/BuyProduct.css">
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 750px)">
    <link rel="stylesheet" href="assets/styles/desktop/style.css" media="screen and (min-width: 750px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>
        <section id="background">
            <div>
                <h1>Risca Faca</h1>
                <p>Deixe o fogo transformar sua fome em felicidade</p>
            </div>
        </section>
        <section id="products">
            <?php
                $pesq = '';
                if (isset($_GET['pesq'])) {
                    $pesq = $_GET['pesq'];
                }

                $products = SelectAllProducts($pesq);

                foreach ($products as $id => $pdr) {
                    print("<div class=\"product\" id=\"product-$id\">");
            ?>
                <figure>
                    <img src="../App/php/scripts/ShowImage.php?id=<?php print $pdr['IMAGEM_ID'] ?>" alt="comida foto">
                </figure>
                <div class="Pdrinfo">
                    <p class="PdrName">
                        <?php
                            $PdrName = substr($pdr['COMIDA_NOME'], 0, 17);
                            if ($PdrName != $pdr['COMIDA_NOME']) {
                                $PdrName .= '...';
                            }
                            print $PdrName;
                        ?>
                    </p>
                    <div class="PdrPriceAndDesc">
                        <p class="PdrDesc">
                            <?php
                            $pdrDesc = substr($pdr['COMIDA_DESC'], 0, 17);
                            if ($pdrDesc != $pdr['COMIDA_DESC']) {
                                $pdrDesc .= '...';
                            }
                            print  $pdrDesc;
                            ?>
                        </p>
                        <p class="PdrPrice">
                            <?php 
                            $price = FormatPrice($pdr['COMIDA_PRECO']);
                            $price = explode('.', $price);
                            print $price[0].'<span>.'.$price[1].'</span>';
                            ?>
                        </p>
                    </div>
                    <button onclick="ShowBuyMenu(<?php print $id ?>)" class="BuyProduct">
                        Comprar Agora
                    </button>
                </div>
            <?php
                print '</div>';
            ?>
        <section id="buyMenu-<?php print $id ?>" class="BuyMenu">
            <span class="material-symbols-outlined" id="CloseButton" onclick="CloseBuyMenu(<?php print $id ?>)">
                Close
            </span>
            <form action="" method="post" id="BuyForm">
                <h1 id="PdrFormName">
                    <?php print $pdr['COMIDA_NOME'] ?>
                </h1>
                <div class="input-group">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado">
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                        <option value="EX">Estrangeiro</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="cepId">Cep</label>
                    <input type="text" name="cep" id="cepId">
                </div>
                <div class="input-group">
                    <label for="ruaId">Rua</label>
                    <input type="text" name="rua" id="ruaId">
                </div>
                <div class="input-group">
                    <label for="bairroId">Bairro</label>
                    <input type="text" name="reference" id="referenceId">
                </div>
                <div class="input-group">
                    <label for="referenceId">Referencia</label>
                    <input type="text" name="reference" id="referenceId">
                </div>
                <div>
                    <button type="submit">
                        Comprar
                    </button>
                </div>
            </form>
        </section>
            <?php
            }
            ?>
        </section>
    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
    <script src="../App/js/ShowBuyMenu.js"></script>
</body>
</html>