<?php
ini_set('memory_limit', '1024M'); // Aumenta para 1GB
ini_set('max_execution_time', 300); // Aumenta o tempo limite para 5 minutos

require_once 'config.php';
require_once 'categorias.php';
require_once 'itens.php';

// Processar ações
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        // Categorias
        case 'add_categoria':
            if ($_POST['codigo'] && $_POST['nome']) {
                cadastrarCategoria($_POST['codigo'], $_POST['nome']);
            }
            break;
        case 'edit_categoria':
            if ($_POST['id'] && $_POST['codigo'] && $_POST['nome']) {
                editarCategoria($_POST['id'], $_POST['codigo'], $_POST['nome']);
            }
            break;
        case 'delete_categoria':
            if ($_GET['id']) {
                deletarCategoria($_GET['id']);
            }
            break;

        // Itens
        case 'add_item':
            if ($_POST['nome'] && $_POST['quantidade'] && $_POST['valor']) {
                cadastrarItem(
                    $_POST['nome'],
                    $_POST['codCategoria'],
                    $_POST['quantidade'],
                    $_POST['valor']
                );
            }
            break;
        case 'edit_item':
            if ($_POST['id'] && $_POST['nome'] && $_POST['quantidade'] && $_POST['valor']) {
                editarItem(
                    $_POST['id'],
                    $_POST['nome'],
                    $_POST['codCategoria'],
                    $_POST['quantidade'],
                    $_POST['valor']
                );
            }
            break;
        case 'delete_item':
            if ($_GET['id']) {
                deletarItem($_GET['id']);
            }
            break;

        // Exportação
        case 'export_categorias':
            exportarCategoriasCSV();
            break;
        case 'export_itens':
            exportarItensCSV();
            break;
    }
    header('Location: index.php');
    exit;
}

$categorias = listarCategorias();
$itens = listarItens();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Inventário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding: 20px;
        }

        .table-container {
            margin-bottom: 2rem;
        }

        .modal {
            transition: opacity 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title is-1 has-text-centered">Sistema de Inventário</h1>

        <!-- Seção Categorias -->
        <div class="box table-container">
            <h2 class="title is-2">Categorias</h2>

            <div class="buttons">
                <!-- Botão Adicionar Categoria -->
                <button class="button is-primary" onclick="abrirModal('modal-add-categoria')">
                    <i class="fas fa-plus"></i>&nbsp;Nova Categoria
                </button>

                <!-- Botão Exportar Categorias -->
                <a href="?action=export_categorias" class="button is-link">
                    <i class="fas fa-file-export"></i>&nbsp;Exportar Categorias
                </a>
            </div>

            <!-- Tabela de Categorias -->
            <div class="table-responsive">
                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= $categoria['idCategoria'] ?></td>
                                <td><?= $categoria['CodCategoria'] ?></td>
                                <td><?= $categoria['Nome'] ?></td>
                                <td>
                                    <button class="button is-small is-info"
                                        onclick="abrirModalEditarCategoria(
                                            <?= $categoria['idCategoria'] ?>,
                                            '<?= $categoria['CodCategoria'] ?>',
                                            '<?= $categoria['Nome'] ?>'
                                        )">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <a href="?action=delete_categoria&id=<?= $categoria['idCategoria'] ?>"
                                        class="button is-small is-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Seção Itens -->
        <div class="box table-container">
            <h2 class="title is-2">Itens</h2>

            <div class="buttons">
                <!-- Botão Adicionar Item -->
                <button class="button is-primary" onclick="abrirModal('modal-add-item')">
                    <i class="fas fa-plus"></i>&nbsp;Novo Item
                </button>

                <!-- Botão Exportar Itens -->
                <a href="?action=export_itens" class="button is-link">
                    <i class="fas fa-file-export"></i>&nbsp;Exportar Itens
                </a>
            </div>

            <!-- Tabela de Itens -->
            <div class="table-responsive">
                <table class="table is-bordered is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td><?= $item['ID'] ?></td>
                                <td><?= $item['Nome'] ?></td>
                                <td><?= $item['CategoriaNome'] ?? 'N/A' ?></td>
                                <td><?= $item['Quantidade'] ?></td>
                                <td>R$ <?= number_format($item['Valor'], 2, ',', '.') ?></td>
                                <td>
                                    <button class="button is-small is-info"
                                        onclick="abrirModalEditarItem(
                                            <?= $item['ID'] ?>,
                                            '<?= $item['Nome'] ?>',
                                            '<?= $item['CodCategoria'] ?>',
                                            <?= $item['Quantidade'] ?>,
                                            <?= $item['Valor'] ?>
                                        )">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <a href="?action=delete_item&id=<?= $item['ID'] ?>"
                                        class="button is-small is-danger"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modais -->
    <?php include 'modais.php'; ?>

    <script>
        // Funções para abrir modais
        function abrirModal(id) {
            document.getElementById(id).classList.add('is-active');
        }

        function fecharModal(id) {
            document.getElementById(id).classList.remove('is-active');
        }

        // Preencher modal de edição de categoria
        function abrirModalEditarCategoria(id, codigo, nome) {
            document.getElementById('edit-categoria-id').value = id;
            document.getElementById('edit-categoria-codigo').value = codigo;
            document.getElementById('edit-categoria-nome').value = nome;
            abrirModal('modal-edit-categoria');
        }

        // Preencher modal de edição de item
        function abrirModalEditarItem(id, nome, codCategoria, quantidade, valor) {
            document.getElementById('edit-item-id').value = id;
            document.getElementById('edit-item-nome').value = nome;
            document.getElementById('edit-item-codCategoria').value = codCategoria;
            document.getElementById('edit-item-quantidade').value = quantidade;
            document.getElementById('edit-item-valor').value = valor;
            abrirModal('modal-edit-item');
        }
    </script>
</body>

</html>