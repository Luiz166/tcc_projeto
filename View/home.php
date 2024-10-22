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
            <span>Olá</span>
            <?php echo "<span>" . htmlspecialchars($user_name) . "</span>"; ?>
        </header>
        <div class="balance-card">
            <div class="total-balance">
                <span>Saldo total</span>
                <span>R$ <?php echo number_format($saldo_total, 2, ',', '.'); ?></span>
            </div>
            <div class="income-expanses">
                <div>
                    <span>Ganhos</span>
                    <span>R$<?php echo number_format($total_renda, 2, ',', '.'); ?></span>
                </div>
                <div>
                    <span>Despesas</span>
                    <span>R$<?php echo number_format($total_despesa, 2, ',', '.'); ?></span>
                </div>
            </div>
        </div>
        <div class="transactions">
            <span>Histórico de Transações</span>
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
        $sql_obter_meta = "SELECT id, nome FROM metas WHERE user_id = $user_id";
        $result_obter_meta = $conn->query($sql_obter_meta);
        if (isset($_POST["add-button"])) {
            

            $transactionType = $_POST["transaction-type"];
            //converting
            $transactionType = ($transactionType === 'Renda') ? 1 : 0;
            $value = $_POST["value"];
            $name = $_POST["name"];
            $date = $_POST["date"];
            $categoria = $_POST["categoria"];
            $meta_id = $_POST['meta_id'];
            
            if($transactionType == 1){
                $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id) VALUES ( ?, ?, ?, ?, ?, ?)";
    
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("dssisi", $value, $name, $date, $transactionType, $categoria, $user_id);
                $stmt->execute();

            }
            else{
                $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id, meta_id) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
                if($meta_id <= 0){
                    $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id) VALUES ( ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("dssisi", $value, $name, $date, $transactionType, $categoria, $user_id);
                    $stmt->execute();
                }
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("dssisii", $value, $name, $date, $transactionType, $categoria, $user_id, $meta_id);
                $stmt->execute();
                $sql_meta = "UPDATE metas SET gasto_total = gasto_total + ? WHERE id = ?";
                $stmt_meta = $conn->prepare($sql_meta);
                $stmt_meta->bind_param("di", $value, $meta_id);
                $stmt_meta->execute();
                $stmt_meta->close();
            }
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>
        <form class="registerForm" method="post">
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
                <input type="text" name="categoria" id="" maxlength="20" class="floating-input" placeholder=" ">
                <label class="floating-label">Categoria</label>
            </div>
            <div class="floating-label-group">
                <input type="date" name="date" id="" placeholder=" " required class="floating-input">
                <label class="floating-label">Data</label>
            </div>
            <div class="floating-label-group">
                <label for="meta_id">Selecione uma meta (se for despesa):</label>
                <select name="meta_id">
                    <option value="0">Nenhuma meta</option>
                    <?php if($result_obter_meta->num_rows > 0): ?>
                        <?php while($row = $result_obter_meta->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nome']) ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">Você não tem nenhuma meta</option>
                    <?php endif; ?>
                </select>
            </div>
            <input type="submit" value="Adicionar" name="add-button" class="registerBtn">
        </form>
    </section>
    <script src="/Resources/home.js"></script>
</body>

</html>