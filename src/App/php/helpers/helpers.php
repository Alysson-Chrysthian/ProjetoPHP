<?php
    function ValidarCodigo($codigo) {
        if (!is_numeric($codigo)) {
            return false;
        }
        if (!strlen($codigo) == 6) {
            return false;
        }
        return true;
    }

    function VerificarLogin() {
        if (isset($_COOKIE['user_id'])) {
            $_SESSION['user_id'] = $_COOKIE['user_id'];
        }
    
        if (isset($_SESSION['user_id'])) {
            header('index.php');
            die();
        }
    }

    function DestruirVariaveis(array $vars) {
        foreach ($vars as $v) {
            unset($v);
        }
    }