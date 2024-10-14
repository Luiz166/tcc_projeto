<?php
session_start();
$user_id = $_SESSION['user'];
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
require_once "../Resources/conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/home.css">
    <link rel="stylesheet" href="/Style/statistics.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <span>Estatísticas</span>
            <div class="time-frame">
                <button class="time-btn" id="btn-semana">Semana</button>
                <button class="time-btn" id="btn-mes">Mês</button>
                <button class="time-btn" id="btn-ano">Ano</button>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
        <section class="transactions">
            <span>Transações</span>
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th class="transactions-table-nome" scope="col">Nome</th>
                        <th class="transactions-table-valor" scope="col">Valor</th>
                        <th class="transactions-table-data" scope="col">Data</th>
                        <th class="transactions-table-tipo" scope="col">Tipo</th>
                        <th class="transactions-table-cat" scope="col">Categoria</th>
                        <th class="transactions-table-del" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../Resources/showTransactions.php'; ?>
                </tbody>
            </table>
        </section>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="/View/home.php">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="#">
                    <img src="/Resources/Icons/chart-simple-solid.svg" alt="">
                </a>
                <a href="/View/wallet.php">
                    <img src="/Resources/Icons/wallet-solid.svg" alt="">
                </a>
                <a href="/View/profile.php">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/Resources/chart.js"></script>
</body>
</html>