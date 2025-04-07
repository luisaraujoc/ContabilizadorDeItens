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

function exportarCategoriasCSV() {
    $categorias = listarCategorias();
    
    // Configurar headers para download CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="categorias.csv"');
    
    // Criar output stream
    $output = fopen('php://output', 'w');
    
    // Escrever cabeçalhos
    fputcsv($output, ['ID', 'Código', 'Nome'], ';');
    
    // Escrever dados
    foreach ($categorias as $categoria) {
        fputcsv($output, [
            $categoria['idCategoria'],
            $categoria['CodCategoria'],
            $categoria['Nome']
        ], ';');
    }
    
    fclose($output);
    exit;
}
?>