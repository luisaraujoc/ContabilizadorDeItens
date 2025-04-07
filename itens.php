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
function exportarItensCSV() {
    $itens = listarItens();
    
    // Configurar headers para download CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="itens.csv"');
    
    // Criar output stream
    $output = fopen('php://output', 'w');
    
    // Escrever cabeçalhos
    fputcsv($output, ['ID', 'Nome', 'Categoria', 'Quantidade', 'Valor Unitário'], ';');
    
    // Escrever dados
    foreach ($itens as $item) {
        fputcsv($output, [
            $item['ID'],
            $item['Nome'],
            $item['CategoriaNome'] ?? 'N/A',
            $item['Quantidade'],
            number_format($item['Valor'], 2, ',', '.')
        ], ';');
    }
    
    fclose($output);
    exit;
}
?>