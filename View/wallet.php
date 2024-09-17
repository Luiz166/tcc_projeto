<?php
session_start();
$user_id = $_SESSION['user'];
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
require_once "../resources/conn.php";
?>

<?php 
include "../resources/balanceRendaDespesa.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/home.css">
    <link rel="stylesheet" href="/Style/wallet.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <span>Carteira</span>
        </header>
        <section class="balance">
            <span>Saldo Total</span>
            <span>R$<?php echo number_format($saldo_total, 2, ',', '.'); ?></span>
        </section>
        <div class="transactions">
            <span>Transações</span>
            <?php include '../resources/showTransactions.php'; ?>
        </div>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="/View/home.php">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="/View/statistics.php">
                    <img src="/Resources/Icons/chart-simple-solid.svg" alt="">
                </a>
                <a href="#">
                    <img src="/Resources/Icons/wallet-solid.svg" alt="">
                </a>
                <a href="/View/profile.php">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
        </footer>
    </div>
</body>
</html>