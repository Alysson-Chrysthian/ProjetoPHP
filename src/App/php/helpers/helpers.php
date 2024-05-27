<?php
    function VerifyLogin() 
    {
        if (isset($_COOKIE['user_id'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
        }
        return isset($_SESSION['user_id']);
    }

    
    function GenerateVerifyCode() 
    {
        $VerifyCode = '';

        for ($i=0;$i<6;$i++) {
            $VerifyCode .= (string) rand(0, 9);
        }
        return $VerifyCode;
    }


    function VerifyCode($codeUserInput, $codeSystemInput)
    {
        if (isset($codeUserInput) && isset($codeSystemInput)) {
            return $codeSystemInput == $codeUserInput; 
        } 
        return false;
    }


    function CreateUserIdCookie($user_id)
    {
        setcookie('user_id', $user_id, time() + ((3600 *24)*360),'/');
    }


    function UnsetVariables(array $Vars) 
    {
        foreach ($Vars as $v) {
            unset($v);
        }
    }