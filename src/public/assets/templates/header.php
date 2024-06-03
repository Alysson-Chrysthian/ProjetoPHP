<?php
    use App\Enums\UserAcess\UserAcess;
    use App\Class\Database\Database;

    $sql = "SELECT * FROM clientes WHERE CLIENTE_ID = :id";

    try {
        $conn = new Database();
        $conn = $conn->connect();
        $query = $conn->prepare($sql);
        $query->execute([':id' => $_SESSION['user_id']]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header($_SERVER['SERVER_PROTOCOL'].' 403');
        exit();
    }
?>
<figure>
    <a href="index.php"><img src="assets/images/figures/RiscaFaca-Logo.png" alt="Logo Da Risca Faca"></a>
</figure>
<nav>
    <span class="material-symbols-outlined" id="menuButton" onclick="ShowMenu()">
        menu
    </span>
    <menu id="Slide-Menu">
        
        <div id="form">
            <form action="index.php" method="get">
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
                <a href="UserProfile.php"><?php echo $user['CLIENTE_NOME'] ?></a>
                <a href="../App/php/scripts/Exit.php">Sair</a>
            </div>
        </div>
    </menu>
</nav>

<script src="../App/js/Menu.js"></script>