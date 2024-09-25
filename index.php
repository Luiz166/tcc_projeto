<?php
include 'resources/conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3f51b5">
    <link rel="stylesheet" href="/Style/index.css">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="./templateIcon.png">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <section class="esquerdaLogo">
            <span>projeto</span>
        </section>
        <section class="direitaForm">
            <div class="formImg">
                <img src="/Resources/Img/indexImg.png" alt="loginImg">
            </div>
            <div class="direitaBottom">
                <span>Controle suas finanças, realize seus sonhos!</span>
                <a href="/View/register.php">Começar</a>
                <span>Já tem uma conta?
                    <a href="/View/login.php">Entrar</a>
                </span>
            </div>
        </section>
    </div>
    <script src="index.js"></script>
</body>

</html>