<?php
session_start();
$user_id = $_SESSION['user'];
require_once "../resources/conn.php";

if(isset($_GET['search'])){
    $search = $_GET['search'];

    $search = "%" . htmlspecialchars($search) . "%";

    $sql = "SELECT * FROM transacoes
            WHERE usuario_id = ? AND nome_transacao LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $search);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
        ?>
         <div class="transactions-item">
            <div>
                <span><?php echo htmlspecialchars($row['nome_transacao']); ?></span>
                <span><?php echo htmlspecialchars(date("d/m/Y", strtotime($row['data']))); ?></span>
            </div>
            <div>
                <span><?php echo number_format($row['valor'], 2); ?></span>
                <span>
                    <?php
                    if ($row['tipo_transacao'] == 1) {
                        echo htmlspecialchars("Renda");
                    } else {
                        echo htmlspecialchars("Despesa");
                    }
                    ?>
                </span>
            </div>
            <div>
                <span>categoria</span>
                <span><?php echo htmlspecialchars($row['categoria']); ?></span>
            </div>
            <form method="POST" action="../Resources/deleteTransaction.php" class="delete-transaction-container">
                <input type="hidden" name="transaction_id" value="<?php echo $row['transacao_id'] ?>">
                <input type="hidden" name="transaction_page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <button type="submit" id="delete-transaction-btn">
                    <img src="../Resources/icons/delete-left-solid.svg" alt="delete">
                </button>
            </form>
        </div>
        <?php
            }
        }
    }else{
        echo "Transação não encontrada";
}
$stmt->close();
$conn->close();
?>