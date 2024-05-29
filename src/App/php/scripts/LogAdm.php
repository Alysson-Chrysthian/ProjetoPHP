<?php
    require_once '../../../vendor/autoload.php';
    require_once '../helpers/helpers.php';

    session_start();

    use App\Class\Controller\Adm;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $Adm = new Adm($_POST['adm_id'], $_POST['password']);

        $validate = VerifyAdm($Adm);

        if (!$validate) {
            $_SESSION['erro'] = 'Informações inseridas sao invalidas';
            header('location: ../../../public/LogInAdm.php');
            die();
        }

        $AdmId = $Adm->VerifyIfAdmExist();
        CreateAdminSession($AdmId);

    }

    header('location: ../../../public/index.php');
