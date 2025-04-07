<?php
require_once 'config.php';

// Listar itens
function listarItens() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT i.*, c.Nome as CategoriaNome 
        FROM Item i 
        LEFT JOIN Categoria c ON i.CodCategoria = c.CodCategoria
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cadastrar item
function cadastrarItem($nome, $codCategoria, $quantidade, $valor) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO Item (Nome, CodCategoria, Quantidade, Valor) 
        VALUES (?, ?, ?, ?)
    ");
    return $stmt->execute([$nome, $codCategoria, $quantidade, $valor]);
}

// Editar item
function editarItem($id, $nome, $codCategoria, $quantidade, $valor) {
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE Item 
        SET Nome = ?, CodCategoria = ?, Quantidade = ?, Valor = ? 
        WHERE ID = ?
    ");
    return $stmt->execute([$nome, $codCategoria, $quantidade, $valor, $id]);
}

// Deletar item
function deletarItem($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM Item WHERE ID = ?");
    return $stmt->execute([$id]);
}

// Exportar itens para XLSX
function exportarItensXLSX() {
    require_once './autoload.php';
    
    // Desativa o uso de cache
    \PhpOffice\PhpSpreadsheet\Settings::setCache(null);
    
    $itens = listarItens();
    
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Cabeçalhos
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nome');
    $sheet->setCellValue('C1', 'Categoria');
    $sheet->setCellValue('D1', 'Quantidade');
    $sheet->setCellValue('E1', 'Valor');
    
    // Dados
    $row = 2;
    foreach ($itens as $item) {
        $sheet->setCellValue('A' . $row, $item['ID']);
        $sheet->setCellValue('B' . $row, $item['Nome']);
        $sheet->setCellValue('C' . $row, $item['CategoriaNome']);
        $sheet->setCellValue('D' . $row, $item['Quantidade']);
        $sheet->setCellValue('E' . $row, $item['Valor']);
        $row++;
    }
    
    // Gerar arquivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="itens.xlsx"');
    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>