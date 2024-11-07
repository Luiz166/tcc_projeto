<?php
$sql = "SELECT * FROM transacoes WHERE tipo_transacao = 0 AND usuario_id = $user_id ORDER BY data DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->Fetch_assoc()) {
?>
        <tr>
            <th scope="row">
                <?php echo htmlspecialchars($row['nome_transacao']); ?> <br>
                <?php echo htmlspecialchars($row['categoria']); ?>
            </th>
            <td>
                R$<?php echo number_format($row['valor'], 2); ?>
            </td>
            <td>
                <form method="POST" action="../Resources/deleteTransaction.php" class="delete-transaction-container">
                    <input type="hidden" name="transaction_id" value="<?php echo $row['transacao_id'] ?>">
                    <input type="hidden" name="transaction_page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <button type="submit" id="delete-transaction-btn">
                        <img src="../Resources/Icons/delete-left-solid.svg" alt="delete">
                    </button>
                </form>
            </td>
        </tr>
<?php
    }
} else {
    echo ("<span>Você não tem transações, adicione!</span>");
}
?>