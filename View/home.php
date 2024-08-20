<?php 
session_start();
$user_id = $_SESSION['user'];
if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}
?>

<?php
    require_once "../resources/conn.php";
    $sql = "SELECT nome FROM usuario WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $user_name = $row['nome'];
    }else{
        $user_name = "Convidado";
    }
?>

<?php
    // Consulta para somar todas as rendas
    $sql_renda = "SELECT SUM(valor) AS total_renda FROM transacoes WHERE tipo_transacao = 1";
    $result_renda = $conn->query($sql_renda);
    $row_renda = $result_renda->fetch_assoc();
    $total_renda = (float) ($row_renda['total_renda'] ?? 0);

    // Consulta para somar todas as despesas
    $sql_despesa = "SELECT SUM(valor) AS total_despesa FROM transacoes WHERE tipo_transacao = 0";
    $result_despesa = $conn->query($sql_despesa);
    $row_despesa = $result_despesa->fetch_assoc();
    $total_despesa = (float) ($row_despesa['total_despesa'] ?? 0);

    $saldo_total = $total_renda - $total_despesa;
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
            <span>Bom dia</span>
            <?php echo "<span>" . htmlspecialchars($user_name) . "</span>"; ?>
        </header>
        <div class="balance-card">
            <div class="total-balance">
                <span>Saldo total</span>
                <span> <?php echo number_format($saldo_total, 2, ',', '.'); ?></span>
            </div>
            <div class="income-expanses">
                <div>
                    <span>Ganhos</span>
                    <span><?php echo number_format($total_renda, 2, ',', '.'); ?></span>
                </div>
                <div>
                    <span>Despesas</span>
                    <span><?php echo number_format($total_despesa, 2, ',', '.'); ?></span>
                </div>
            </div>
        </div>
        <div class="transactions">
            <span>Histórico de Transações</span>
            <?php include '../resources/showTransactions.php'; ?>
        </div>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="#">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="/View/statistics.php">
                    <img src="/Resources/Icons/chart-simple-solid.svg" alt="">
                </a>
                <a href="/View/wallet.php">
                    <img src="/Resources/Icons/wallet-solid.svg" alt="">
                </a>
                <a href="/View/profile.php">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
            <button class="add-button">+</button>
        </footer>
    </div>
    <div class="overlay"></div>
    <section class="add-transaction-container">
        <?php 
        if(isset($_POST["add-button"])){

            $transactionType = $_POST["transaction-type"];
            //converting
            $transactionType = ($transactionType === 'Renda') ? 1 : 0;
            $value = $_POST["value"];
            $name = $_POST["name"];
            $date = $_POST["date"];

            $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao) VALUES ( ?, ?, ?, ? )";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dssi", $value, $name, $date, $transactionType);
            $stmt->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>
        <form action="" class="registerForm" method="post">
            <div class="switch-container">
                <input type="radio" name="transaction-type" id="income" value="Renda">
                <label for="income">Renda</label>
                <input type="radio" name="transaction-type" id="expense" value="Despesa">
                <label for="expense">Despesa</label>
            </div>
                <div class="floating-label-group">
                    <input type="number" name="value" id="valueInput" required class="floating-input" placeholder=" ">
                    <label class="floating-label">Valor</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="name" placeholder=" " maxlength="30" required id="" class="floating-input">
                    <label class="floating-label">Nome</label>
                </div>
                <div class="floating-label-group">
                    <input type="date" name="date" id="" placeholder=" " required class="floating-input">
                    <label class="floating-label">Data</label>
                </div>
                <input type="submit" value="Adicionar" name="add-button" class="registerBtn">
        </form>
    </section>
    <script src="/Resources/home.js"></script>
</body>
</html>