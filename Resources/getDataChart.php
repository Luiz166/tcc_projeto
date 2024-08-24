

<?php
include('conn.php');

$periodo = $_GET['periodo'];

switch ($periodo) {
    case 'ano':
        $sql = "SELECT MONTHNAME(data) AS label, 
                       SUM(CASE WHEN tipo_transacao = 1 THEN valor ELSE 0 END) - 
                       SUM(CASE WHEN tipo_transacao = 0 THEN valor ELSE 0 END) AS receita
                FROM transacoes
                WHERE YEAR(data) = YEAR(CURDATE())
                GROUP BY MONTH(data)";
        break;

    case 'mes':
        $sql = "SELECT WEEK(data, 1) AS label, 
                       SUM(CASE WHEN tipo_transacao = 1 THEN valor ELSE 0 END) - 
                       SUM(CASE WHEN tipo_transacao = 0 THEN valor ELSE 0 END) AS receita
                FROM transacoes
                WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())
                GROUP BY WEEK(data, 1) ORDER BY label ASC";
        break;

    case 'semana':
        $sql = "SELECT DAYNAME(data) AS label, 
                       SUM(CASE WHEN tipo_transacao = 1 THEN valor ELSE 0 END) - 
                       SUM(CASE WHEN tipo_transacao = 0 THEN valor ELSE 0 END) AS receita
                FROM transacoes
                WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)
                GROUP BY DAY(data) ORDER BY label";
        break;
}

$result = $conn->query($sql);
$labels = [];
$dados = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($periodo == 'mes'){
            $labels[] = intval($row['label'])%4;
        }else{
            $labels[] = $row['label'];
        }
        $dados[] = $row['receita'];
    }
}

echo json_encode(['labels' => $labels, 'dados' => $dados]);

$conn->close();
?>