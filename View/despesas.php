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
        <h1>Consumo total</h1>
        <main>
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
                        <?php include '../Resources/showTransactions.php'; ?>
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
            if($transactionType == 1){
                $sql = "INSERT INTO transacoes (valor, nome_transacao, data, tipo_transacao, categoria, usuario_id) VALUES ( ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("dssisi", $value, $name, $date, $transactionType, $categoria, $user_id);
                $stmt->execute();

            }
            else{ //despesa
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
            }
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        ?>
        <form class="registerForm" method="post">
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

            <input type="submit" value="Adicionar" name="add-button" class="registerBtn">
        </form>
    </section>
</body>
</html>