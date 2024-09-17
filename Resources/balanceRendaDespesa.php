   <?php
   // Consulta para somar todas as rendas
    $sql_renda = "SELECT SUM(valor) AS total_renda FROM transacoes WHERE tipo_transacao = 1 AND usuario_id = $user_id";
    $result_renda = $conn->query($sql_renda);
    $row_renda = $result_renda->fetch_assoc();
    $total_renda = (float) ($row_renda['total_renda'] ?? 0);

    // Consulta para somar todas as despesas
    $sql_despesa = "SELECT SUM(valor) AS total_despesa FROM transacoes WHERE tipo_transacao = 0 AND usuario_id = $user_id";
    $result_despesa = $conn->query($sql_despesa);
    $row_despesa = $result_despesa->fetch_assoc();
    $total_despesa = (float) ($row_despesa['total_despesa'] ?? 0);

    $saldo_total = $total_renda - $total_despesa;
    ?>