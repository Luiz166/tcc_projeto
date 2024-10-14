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
                            echo "<button type='submit' name='mes' value='$i'>".
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
            $sql = "SELECT * FROM metas WHERE mes = ?";
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
                    echo "<span> R$" . htmlspecialchars($row['valor_meta']) . "</span>";
                    echo "</div>";
                    echo "<div class='goalsResult'>";
                    echo "<span>Rendimento total</span>";
                    echo "<span> R$" . number_format($row['rendimento'], 2, ',', '.') . "</span>";
                    echo "</div>";          
                }
                echo "</div>";
            } else {
                echo "<p>Nenhuma meta encontrada para o mês </p>" . mesParaNome($mes);
            }}else{
                echo "<p>Selecione um mês para exibir as metas</p>";
            }
        ?>
        <div class="goalsDiv">
            <button type="button" class="showFormBtn">Criar meta</button>
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
                    <button name="add-button" type="submit">Adicionar meta</button>
                </form>
                <?php
                    if(isset($_POST['add-button'])){
                        $meta_id = $_POST['meta_id'];
                        $nome = $_POST['meta_name'];
                        $value = $_POST['meta_value'];

                        $sql_create_meta = "INSERT INTO metas (nome, valor_meta, mes) VALUES (?, ?, ?)";
                        $stmt_create_meta = $conn->prepare($sql_create_meta);
                        $stmt_create_meta->bind_param('sdi', $nome, $value, $meta_id);
                        $stmt_create_meta->execute();
                        $stmt_create_meta->close();
                    }
                ?>
            </div>
        </div>
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