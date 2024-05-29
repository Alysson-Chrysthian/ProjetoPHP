<?php
    require_once '../vendor/autoload.php';
    require_once '../App/php/Helpers/Helpers.php';

    session_start();

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
    <title>Risca Faca Food Corporation</title>
    <link rel="stylesheet" href="assets/styles/android/style.css">
    <link rel="stylesheet" href="assets/styles/desktop/style.css" media="screen and (min-width: 620px)">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
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