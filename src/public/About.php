<?php
    session_start();

    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    $Logged = VerifyLogin();
    if (!$Logged) {
        header('location: SignUp.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="stylesheet" href="assets/styles/android/header.css">
    <link rel="stylesheet" href="assets/styles/android/footer.css">
    <link rel="stylesheet" href="assets/styles/android/style.css">
    <link rel="stylesheet" href="assets/styles/desktop/header.css" media="screen and (min-width: 865px)">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body onresize="ChangeMenuStyles()">
    <header>
        <?php require_once 'assets/templates/header.php' ?>
    </header>
    <main>

    </main>
    <footer>
        <?php require_once 'assets/templates/footer.php' ?>
    </footer>
</body>
</html>