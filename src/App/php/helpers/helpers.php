<?php

    use App\Class\Controller\Adm;
    use App\Class\Controller\User;
    use App\Enums\UserAcess\UserAcess;

    function VerifyLogin() 
    {
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['acessType'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['acessType'] = $_COOKIE['acessType'];
        }
        return isset($_SESSION['user_id']);
    }


    function VerifyError() 
    {
        if (isset($_SESSION['erro'])) {
            print('<p id="erro">'.$_SESSION['erro'].'</p>');
            unset($_SESSION['erro']);
        }
    }


    function VerifyUser(User $user) 
    {
        if (!$user->ValidateUserInfo()) {
            return false;
        }
        if ($user->VerifyIfUserExist()) {
            return false;
        }
        return true;
    }


    function VerifyAdm(Adm $adm)
    {
        if (!$adm->ValidateAdmInfo()) {
            return false;
        }
        if (!$adm->VerifyIfAdmExist()) {
            return false;
        }
        return true;
    }


    function CreateUserSession($id, $cookie)
    {
        if ($cookie) {
            setcookie('user_id', $id, time() + ((3600*24)*360), '/');
            setcookie('acessType', serialize(UserAcess::USER_NORMAL), time() + ((3600*24)*360), '/');
        }
        $_SESSION['user_id'] = $id;
        $_SESSION['acessType'] = serialize(UserAcess::USER_NORMAL);

    }


    function CreateAdminSession($id)
    {
        $_SESSION['user_id'] = $id;
        $_SESSION['acessType'] = serialize(UserAcess::USER_ADM);
    }
