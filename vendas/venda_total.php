<?php
include '../conexao_bd.php'; // Conexão com o Banco de dados

// Verifica se o parâmetro 'intervalo' foi enviado
if (isset($_GET['intervalo'])) {
    $intervalo = $_GET['intervalo'];

    // Define as datas de início e fim com base no intervalo
    switch ($intervalo) {
        case 'semana':
            $dataInicio = date('Y-m-d', strtotime('-1 week'));
            $dataFim = date('Y-m-d');
            break;
        case 'mes':
            $dataInicio = date('Y-m-01');
            $dataFim = date('Y-m-t');
            break;
        case 'ano':
            $dataInicio = date('Y-01-01');
            $dataFim = date('Y-12-31');
            break;
        default:
            echo "Intervalo inválido.";
            exit;
    }

    // Sua consulta SQL usando as datas calculadas
    $sql = "
        SELECT DISTINCT  k.NOME AS VENDEDOR,
            sum(a.LCTVALOR) AS VENDAS,
            sum(a.LCTVALOR) / COUNT(e.PEDSEQUENCIAL) AS TM,
            m.MTVVALORMETA AS META
        FROM TB_LCT_LANCAMENTOS a
            INNER JOIN TB_LTV_LANCAMENTOVENDA b ON b.LCTID = a.LCTID 
            INNER JOIN TB_VEN_VENDA c ON c.VENID = b.VENID 
            INNER JOIN TB_VPE_VENDAPEDIDOS d ON d.VENID_VENDA = c.VENID 
            INNER JOIN TB_PED_PEDIDO e ON e.PEDID = d.PEDID_PEDIDO 
            INNER JOIN TB_CLI_CLIENTE f ON f.CLIID = c.CLIID_PAGADOR 
            INNER JOIN TB_PES_PESSOA g ON g.PESID = f.PESID 
            INNER JOIN TB_USU_USUARIO h ON h.USUID = a.USUID
            INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = e.VNDID_PRIMEIRO  
            INNER JOIN TB_NIVEL_ACESSO  k ON k.PESID = i.PESID 
            INNER JOIN TB_DMV_DETALHEMETAVEND l ON l.VNDID = i.VNDID 
            INNER JOIN TB_MTV_METASVENDEDOR m ON m.MTVID = l.MTVID
            INNER JOIN TB_TVN_TIPOVENDA o ON o.TVNID = e.TVNID 
        WHERE e.FILID_FILIAL = '5'
            AND a.LCTDATALANCAMENTO BETWEEN '$dataInicio' AND '$dataFim'
            AND e.MCVID IS NULL
        GROUP BY o.TVNDESCRICAO , k.NOME, m.MTVVALORMETA 
        ORDER BY VENDAS DESC
    ";
    $result = $conn->query($sql);

    if ($result !== false) {
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            echo json_encode(array('message' => 'Nenhum resultado encontrado.'));
        }
    } else {
        // Lida com erros na execução da consulta
        $errorInfo = $conn->errorInfo();
        echo json_encode(array('error' => 'Erro na execução da consulta: ' . $errorInfo[2]));
    }
    

    $conn = null; // Fecha a conexão PDO
    exit;
}
// Certifique-se de fechar a chave if adequadamente
?>
