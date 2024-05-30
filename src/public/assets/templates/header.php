<?php
    use App\Enums\UserAcess\UserAcess;
?>
<figure>
    <img src="assets/images/figures/RiscaFaca-Logo.png" alt="Logo Da Risca Faca">
</figure>
<nav>
    <span class="material-symbols-outlined" id="menuButton" onclick="ShowMenu()">
        menu
    </span>
    <menu id="Slide-Menu">
        
        <div id="form">
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="text" name="pesq" id="pesqId" placeholder="pesquisar comida">
                <button type="submit">
                    <span class="material-symbols-outlined" id="SearchIcon">
                        Search
                    </span>
                </button>
            </form>
            <div id="links">
                <a href="index.php">Inicio</a>
                <a href="About.php">Sobre</a>
                <?php
                    if (unserialize($_SESSION['acessType']) == UserAcess::USER_ADM) {
                        print '<a href="FoodAdd.php">Cadastrar Produto</a>';
                    }
                ?>
                <a href="../App/php/scripts/Exit.php">Sair</a>
            </div>
        </div>
    </menu>
</nav>

<script src="../App/js/Menu.js"></script>