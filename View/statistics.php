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
    <link rel="stylesheet" href="/Style/carteira.css">
    <link rel="stylesheet" href="/Style/statistics.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <h1>Consumo Total</h1>
        <main>
            <div class="time-frame">
                <button type="button" id="btn-semana">Semana</button>
                <button type="button" id="btn-mes">Mês</button>
                <button type="button" id="btn-ano">Ano</button>
            </div>
            <div>
                <canvas id="myChart"></canvas>
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
                        <?php include '../Resources/getDespesas.php'; ?>
                    </tbody>
                </table>
            </div>
            <button type="button" class="add-button">Criar novo gasto</button>
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
    <section class="add-transaction-container hidden">
        <?php
        $sql_obter_meta = "SELECT id, nome FROM metas WHERE user_id = $user_id";
        $result_obter_meta = $conn->query($sql_obter_meta);
        if (isset($_POST["add-button"])) {
            

            $transactionType = 0;
            //converting
            $transactionType = ($transactionType === 'Renda') ? 1 : 0;
            $value = $_POST["value"];
            $name = $_POST["name"];
            $date = $_POST["date"];
            $categoria = $_POST["categoria"];
            $meta_id = $_POST['meta_id'];
            $num_parcelas = $_POST['parcela_input'];
            
            //renda
                if (isset($_POST['parcela_check'])) { // Despesa Parcelada
                    $valorParcela = $value / $num_parcelas;
                    
                    $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id" . ($meta_id > 0 ? ", meta_id" : "") . ") VALUES (?, ?, ?, ?, ?, ?" . ($meta_id > 0 ? ", ?" : "") . ")";
                    
                    $stmt = $conn->prepare($sql);
                    
                    for ($i = 0; $i < $num_parcelas; $i++) {
                        $dataParcela = date("Y-m-d", strtotime("+$i month", strtotime($date)));
                        if ($meta_id > 0) {
                            $stmt->bind_param("dssisii", $valorParcela, $name, $dataParcela, $transactionType, $categoria, $user_id, $meta_id);
                        } else {
                            $stmt->bind_param("dssisi", $valorParcela, $name, $dataParcela, $transactionType, $categoria, $user_id);
                        }
                        $stmt->execute();
                    }
                    
                    $stmt->close();
                } else { // Despesa normal
                    $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id" . ($meta_id > 0 ? ", meta_id" : "") . ") VALUES (?, ?, ?, ?, ?, ?" . ($meta_id > 0 ? ", ?" : "") . ")";
                    
                    $stmt = $conn->prepare($sql);
                    
                    if ($meta_id > 0) {
                        $stmt->bind_param("dssisii", $value, $name, $date, $transactionType, $categoria, $user_id, $meta_id);
                    } else {
                        $stmt->bind_param("dssisi", $value, $name, $date, $transactionType, $categoria, $user_id);
                    }
                    
                    $stmt->execute();
                    $stmt->close();
                }
                
                // Atualiza o valor da meta se houver uma
                if ($meta_id > 0) {
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
            <h1>Adicionar despesa</h1>
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
                <label for="meta_id">Selecione uma meta:</label>
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
            <div class="floating-label-group">
                <input type="checkbox" name="parcela_check" id="parcela_check" />
                <label for="parcela_check">Parcelado</label>
                
            </div>
            <div class="floating-label-group" id="parcela_div">
                <label for="parcela_input">Número de parcelas</label>
                <input type="number" id="parcela_input" name="parcela_input"/>
            </div>
            <input type="submit" value="Adicionar" name="add-button" class="registerBtn">
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/Resources/chart.js"></script>
</body>
</html>