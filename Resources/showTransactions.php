<?php
$sql = "SELECT nome_transacao, valor, data, tipo_transacao FROM transacoes ORDER BY data DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->Fetch_assoc()) {
?>
        <div class="transactions-item">
            <div>
                <span><?php echo htmlspecialchars($row['nome_transacao']); ?></span>
                <span><?php echo htmlspecialchars(date("F j, Y", strtotime($row['data']))); ?></span>
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
        </div>
<?php
    }
} else {
    echo ("<span>Você não tem transações, adicione!</span>");
}
?>