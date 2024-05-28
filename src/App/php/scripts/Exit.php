<?php
    session_start();

    session_destroy();

    setcookie('user_id', '', time(), '/');
    setcookie('acessType', '', time(), '/');

    header('location: ../../../public/index.php');

