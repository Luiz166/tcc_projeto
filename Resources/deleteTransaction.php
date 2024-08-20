<?php
require_once "conn.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $transaction_id = $_POST['transaction_id'];
    $transaction_page_url = $_POST['transaction_page_url'];

    $sql_delete = 'DELETE FROM transacoes WHERE transacao_id = ?';

    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $transaction_id);

    if($stmt->execute()){
        echo "Transação deletada.";
        header("Location: $transaction_page_url");
        exit();
    }else{
        echo "Erro deletando transação: " . $conn->error;
    }

    $stmt-> close();
    $conn-> close();
}
?>