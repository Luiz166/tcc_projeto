<?php
$sql = "SELECT * FROM transacoes WHERE usuario_id = $user_id ORDER BY data DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->Fetch_assoc()) {
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
} else {
    echo ("<span>Você não tem transações, adicione!</span>");
}
?>