<?php

    use App\Class\Controller\Adm;
    use App\Class\Controller\User;
    use App\Enums\UserAcess\UserAcess;
    use App\Class\Controller\Food;

    function VerifyLogin() 
    {
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['acessType'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['acessType'] = $_COOKIE['acessType'];
        }
        return isset($_SESSION['user_id']);
    }


    function VerifyUser(User $user) 
    {
        if (!$user->ValidateInfo()) {
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


    function IsInfoSet(array | object $info)
    {
        $set = true;
        foreach ($info as $v) {
            if (!isset($v) || empty($v)) {
                $set = false;
                break;
            }
        }
        return $set;
    }


    function IsImage($file) 
    {
        $IsImage = false;

        $acceptFormats = [
            'jpeg',
            'jpg',
            'png',
        ];

        if (is_uploaded_file($file['tmp_name'])) {
            $FileFormat = explode('.', $file['name'])[1];

            foreach ($acceptFormats as $v) {
                if ($v === $FileFormat) {
                    $IsImage = true;
                    break;
                }
            }
        }

        return $IsImage;
    }

    function SaveImageBinaryCode($file)
    {
        $format = explode('/', $file['type']);
        $format = $format[1];

        $dir = time().".$format";
        $dir = 'assets/images/uploads/'.$dir;

        move_uploaded_file($file['tmp_name'], $dir);

        $IsImage = IsImage($file, $dir);

        $image = fopen($dir, 'r');
        $imageBinaryCode = fread($image, filesize($dir));
        
        unlink($dir);
        
        return $imageBinaryCode;
    }

