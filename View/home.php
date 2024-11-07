<?php
session_start();
$user_id = $_SESSION['user'];
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>

<?php
require_once "../Resources/conn.php";
$sql = "SELECT nome FROM usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['nome'];
} else {
    $user_name = "Convidado";
}
?>

<?php
include "../Resources/balanceRendaDespesa.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/home.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <header>
            <span>Olá, <?php echo htmlspecialchars($user_name) ?></span>
            <span>Comece seu planejamento</span>
        </header>
        <main>
            <div class="card">
                <h2 class="card-title">Carteira</h2>
                <div>
                    <span class="card-subtitle">Sua carteira</span>
                    <a href="./carteira.php" class="card-link">Adicionar</a>
                </div>
            </div>
            <div class="card">
                <h2 class="card-title">Despesas</h2>
                <div>
                    <span class="card-subtitle">Despesas totais</span>
                    <a href="./statistics.php" class="card-link">Adicionar</a>
                </div>
            </div>
            <div class="card">
                <h2 class="card-title">Planejamento</h2>
                <div>
                    <span class="card-subtitle">Metas</span>
                    <a href="./goals.php" class="card-link">Adicionar</a>
                </div>
            </div>
            <div class="transactions">
                <h2>Histórico</h2>
                <table class="transactions-table">
                <thead>
                    <tr>
                        <th class="transactions-table-nome" scope="col"></th>
                        <th class="transactions-table-cat" scope="col"></th>
                        <th class="transactions-table-del" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php include '../Resources/showTransactions.php'; ?>
                </tbody>
            </table>
            </div>
        </main>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="/View/home.php">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="/View/profile.php">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
        </footer>
    </div>
</body>

</html>