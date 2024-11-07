<?php
session_start();
require("../Resources/conn.php");
$user_id = $_SESSION['user'];
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
include "../Resources/balanceRendaDespesa.php";
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
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <span>Planejamento</span>
        </header>
        <div class="time-select">
            <form method="get" action="goals.php" >
                <div>
                    <?php
                        for($i = 1; $i <= 12; $i++){
                            echo "<button type='submit' name='mes' id='$i' class='time-btn' value='$i'>".
                                date('F', mktime(0, 0, 0, $i, 1)).
                                "</button>";
                        }
                    ?>
                </div>
            </form>
        </div>
        <div class="goals">
        <?php
            if ($mes) {
            // Consulta para obter as metas do mês especificado
            $sql = "SELECT mes, 
                    SUM(valor_meta) AS total_meta, 
                    SUM(rendimento) as total_rendimento 
                    FROM metas WHERE mes = ? AND user_id = $user_id GROUP BY mes";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $mes);
            $stmt->execute();
            $result = $stmt->get_result();
            function mesParaNome($mes){
                return strftime('%B', mktime(0, 0, 0, $mes, 1));
            }
            // Verifica se existem resultados
            if ($result->num_rows > 0) {
                echo "<h2>Metas para o mês: " . mesParaNome($mes) . "</h2>";
                // Exibe cada meta
                echo "<div class='goalsResultDiv'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='goalsResult'>";
                    echo "<span>Saldo da meta </span>";
                    echo "<span> R$" . htmlspecialchars($row['total_meta']) . "</span>";
                    echo "</div>";
                    echo "<div class='goalsResult'>";
                    echo "<span>Rendimento total</span>";
                    echo "<span> R$" . number_format($row['total_rendimento'], 2, ',', '.') . "</span>";
                    echo "</div>";          
                }
                echo "</div>";
            } else {
                echo "<p>Nenhuma meta encontrada para o mês </p>" . mesParaNome($mes);
            }}else{
                echo "<p>Selecione um mês para exibir as metas</p>";
            }
        ?>
        
        </div>
        <section class="transactions">
            <span>Histórico</span>
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
        </section>
        <a class="showFormBtn" href="/View/create-goal.php">Nova Meta</a>
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
    <script>
        const showFormBtn = document.querySelector('.showFormBtn');
        const goalsForm = document.querySelector('.formGoals');
        showFormBtn.addEventListener('click', () => {
            if(goalsForm.classList.contains("show")){
                goalsForm.classList.remove("show")
            }else{
                goalsForm.classList.add("show")
            }
        })
    </script>
</body>
</html>