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
                <span>0</span>
            </div>
            <div class="income-expanses">
                <div>
                    <span>Ganhos</span>
                    <span>0</span>
                </div>
                <div>
                    <span>Despesas</span>
                    <span>0</span>
                </div>
            </div>
        </div>
        <div class="transactions">
            <span>Histórico de Transações</span>
            <div class="transactions-item">
                <div>
                    <span>upwork</span>
                    <span>hoje</span>
                </div>
                <div>
                    <span>R$0</span>
                    <span>concluído</span>
                </div>
            </div>
        </div>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="#">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="/View/statistics.html">
                    <img src="/Resources/Icons/chart-simple-solid.svg" alt="">
                </a>
                <a href="/View/wallet.html">
                    <img src="/Resources/Icons/wallet-solid.svg" alt="">
                </a>
                <a href="/View/profile.html">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
            <button class="add-button">+</button>
        </footer>
    </div>
    <div class="overlay"></div>
    <section class="add-transaction-container">
        <form action="" class="registerForm">
            <div class="switch-container">
                <input type="radio" name="switch" id="income" value="Renda">
                <label for="income">Renda</label>
                <input type="radio" name="switch" id="expense" value="Despesa">
                <label for="expense">Despesa</label>
            </div>
                <div class="floating-label-group">
                    <input type="number" name="" id="" required class="floating-input" placeholder=" ">
                    <label class="floating-label">Valor</label>
                </div>
                <div class="floating-label-group">
                    <input type="text" name="" placeholder=" " required id="" class="floating-input">
                    <label class="floating-label">Nome</label>
                </div>
                <div class="floating-label-group">
                    <input type="date" name="" id="" placeholder=" " required class="floating-input">
                    <label class="floating-label">Data</label>
                </div>
                <input type="button" value="Adicionar" class="registerBtn">
        </form>
    </section>
    <script src="/Resources/home.js"></script>
</body>
</html>