<?php
    session_start();

    require_once '../../../vendor/autoload.php';

    use App\Enums\UserAcess\UserAcess;
    use App\Class\Controller\Image;
    use App\Class\Controller\Food;

    if (unserialize($_SESSION['acessType']) != UserAcess::USER_ADM) {
        header('location: ../../../public/index.php');
        exit();
    }
    if (isset($_GET['id'])) {
        Food::DeleteFood($_GET['id']);
        Image::DeleteImage($_GET['id']);
    }

    header('location: ../../../public/FoodList.php');