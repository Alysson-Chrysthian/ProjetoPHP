<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('location: SignUp.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
</head>
<body>
    <h1>Pagina inicial</h1>
</body>
</html>