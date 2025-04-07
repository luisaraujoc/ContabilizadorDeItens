<?php
require_once 'config.php';

// Listar categorias
function listarCategorias() {
    global $pdo;
    $stmt = $pdo->query("SELECT idCategoria, CodCategoria, Nome FROM Categoria");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Cadastrar categoria
function cadastrarCategoria($codigo, $nome) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO Categoria (CodCategoria, Nome) VALUES (?, ?)");
    return $stmt->execute([$codigo, $nome]);
}

// Editar categoria
function editarCategoria($id, $codigo, $nome) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE Categoria SET CodCategoria = ?, Nome = ? WHERE idCategoria = ?");
    return $stmt->execute([$codigo, $nome, $id]);
}

// Deletar categoria
function deletarCategoria($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM Categoria WHERE idCategoria = ?");
    return $stmt->execute([$id]);
}

function exportarCategoriasXLSX() {
    require_once 'autoload.php';

    // Desativa o uso de cache
    \PhpOffice\PhpSpreadsheet\Settings::setCache(null);
    
    $categorias = listarCategorias();
    
    try {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Cabeçalhos
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Código');
        $sheet->setCellValue('C1', 'Nome');
        
        // Dados
        $row = 2;
        foreach ($categorias as $categoria) {
            $sheet->setCellValue('A' . $row, $categoria['idCategoria']);
            $sheet->setCellValue('B' . $row, $categoria['CodCategoria']);
            $sheet->setCellValue('C' . $row, $categoria['Nome']);
            $row++;
        }
        
        // Gerar arquivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="categorias.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
        
    } catch (Exception $e) {
        die("Erro ao exportar: " . $e->getMessage());
    }
}
?>