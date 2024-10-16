<?php
session_start();
require("../Resources/conn.php");
$user_id = $_SESSION['user'];
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
setlocale(LC_TIME, 'pt_BR.UTF-8');

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/home.css">
    <link rel="stylesheet" href="/Style/goals.css">
    <link rel="stylesheet" href="/Style/create-goal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
</head>
<body>
<div class="container">
    <header>
        <a href="/View/goals.php">
            <i class="fa-solid fa-arrow-left fa-xl"></i>
        </a>
    </header>
    <div class="goalsDiv">
        <div class="formGoals">
            <form method="post">
                    <div class="floating-label-group">
                        <input type="text" class="floating-input" name="meta_name" placeholder=" " id=""/>
                        <label class="floating-label">Nome da meta</label>
                    </div>
                    <div class="floating-label-group">
                        <input type="number" required class="floating-input" name="meta_value" placeholder=" "/>
                        <label class="floating-label">Valor da Meta</label>
                    </div>
                    <div class="floating-label-group">
                        <label for="meta_id">Mês</label>
                        <select name="meta_id">
                            <option value="1">Janeiro</option>
                            <option value="2">Fev</option>
                            <option value="3">Mar</option>
                            <option value="4">Abr</option>
                            <option value="5">Mai</option>
                            <option value="6">Jun</option>
                            <option value="7">Jul</option>
                            <option value="8">Ago</option>
                            <option value="9">Set</option>
                            <option value="10">Out</option>
                            <option value="11">Nov</option>
                            <option value="12">Dez</option>
                        </select>
                    </div>
                    <div class="floating-label-group">
                        <input type="checkbox" name="notify"/>
                        <label for="notify">Deseja ser notificado quando estiver próximo de atingir a meta.</label>
                    </div>
                    <button name="add-button" class="add-goal-btn" type="submit">Adicionar meta</button>
                </form>
                <?php
                    if(isset($_POST['add-button'])){
                        $meta_id = $_POST['meta_id'];
                        $nome = $_POST['meta_name'];
                        $value = $_POST['meta_value'];
                        
                        $sql_create_meta = "INSERT INTO metas (nome, valor_meta, mes, user_id) VALUES (?, ?, ?, ?)";
                        $stmt_create_meta = $conn->prepare($sql_create_meta);
                        $stmt_create_meta->bind_param('sdii', $nome, $value, $meta_id, $user_id);
                        $stmt_create_meta->execute();
                        $stmt_create_meta->close();
                    }
                    ?>
            </div>
        </div>
        
    </div>
</body>
</html>