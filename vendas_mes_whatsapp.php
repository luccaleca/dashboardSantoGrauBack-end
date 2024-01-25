<?php
include 'conexao_bd.php'; // Certifique-se de incluir o arquivo de conexão ao banco de dados

$sql = "
SELECT DISTINCT n.TVNDESCRICAO AS TIPO_VENDA,
    SUM(a.LCTVALOR) AS VENDAS,
    SUM(a.LCTVALOR) / COUNT(e.PEDSEQUENCIAL) AS TM,
    k.NOME AS VENDEDOR
FROM TB_LCT_LANCAMENTOS a
    INNER JOIN TB_LTV_LANCAMENTOVENDA b ON b.LCTID = a.LCTID
    INNER JOIN TB_VEN_VENDA c ON c.VENID = b.VENID
    INNER JOIN TB_VPE_VENDAPEDIDOS d ON d.VENID_VENDA = c.VENID
    INNER JOIN TB_PED_PEDIDO e ON e.PEDID = d.PEDID_PEDIDO
    INNER JOIN TB_CLI_CLIENTE f ON f.CLIID = c.CLIID_PAGADOR
    INNER JOIN TB_PES_PESSOA g ON g.PESID = f.PESID
    INNER JOIN TB_USU_USUARIO h ON h.USUID = a.USUID
    INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = e.VNDID_PRIMEIRO
    INNER JOIN TB_NIVEL_ACESSO k ON k.PESID = i.PESID
    INNER JOIN TB_TVN_TIPOVENDA n ON n.TVNID = e.TVNID
WHERE e.FILID_FILIAL = '5'
    AND a.LCTDATALANCAMENTO >= '2024-01-20'
    AND a.LCTDATALANCAMENTO <= '2024-01-25'
    AND e.MCVID IS NULL
GROUP BY n.TVNDESCRICAO, k.NOME
ORDER BY VENDAS DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array('message' => 'Nenhum resultado encontrado.'));
}

$conn->close();
?>
