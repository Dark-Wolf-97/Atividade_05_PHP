<?php
require_once './../urnaService.php';

$lista = array();
$mensagem = '';

function listar() {
    global $lista;
    $urnaService = new UrnaService();
    $lista = $urnaService->listar();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $urnaService = new UrnaService();
    
    if (isset($_POST['criar'])) {
        $result = $urnaService->criar(
            $_POST['urna_nome'],
            $_POST['urna_tipo'],
            $_POST['urna_material'],
            $_POST['urna_preco']
        );
        $mensagem = $result === 'Sucesso' ? 'Urna criada com sucesso!' : 'Erro ao criar urna!';
    }
    
    if (isset($_POST['editar'])) {
        $result = $urnaService->atualizar(
            $_POST['id'],
            $_POST['urna_nome'],
            $_POST['urna_tipo'],
            $_POST['urna_material'],
            $_POST['urna_preco']
        );
        $mensagem = $result ? 'Urna atualizada com sucesso!' : 'Erro ao atualizar urna!';
    }
}

if (isset($_GET['excluir'])) {
    $urnaService = new UrnaService();
    $result = $urnaService->deletar($_GET['excluir']);
    $mensagem = $result ? 'Urna excluída com sucesso!' : 'Erro ao excluir urna!';
}

listar();

function exibirModalUrna($modo = 'criar', $dados = null) {
    $idModal = ($modo == 'criar') ? 'criarUrnaModal' : 'editarUrnaModal';
    $titulo = ($modo == 'criar') ? 'Criar Urna' : 'Editar Urna';
    
    echo '
    <div class="modal fade" id="'.$idModal.'" tabindex="-1" aria-labelledby="'.$idModal.'Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="'.$idModal.'Label">'.$titulo.'</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="hidden" name="'.$modo.'">
                        '.($modo == 'editar' ? '<input type="hidden" name="id" value="'.($dados ? $dados['id'] : '').'">' : '').'
                        <div class="mb-3">
                            <label for="urna_nome_'.$modo.'" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="urna_nome_'.$modo.'" name="urna_nome" 
                                value="'.($dados ? $dados['nome'] : '').'" required>
                        </div>
                        <div class="mb-3">
                            <label for="urna_tipo_'.$modo.'" class="form-label">Tipo</label>
                            <select class="form-select" id="urna_tipo_'.$modo.'" name="urna_tipo" required>
                                <option value="Adulto" '.($dados && $dados['tipo'] == 'Adulto' ? 'selected' : '').'>Adulto</option>
                                <option value="Infantil" '.($dados && $dados['tipo'] == 'Infantil' ? 'selected' : '').'>Infantil</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="urna_material_'.$modo.'" class="form-label">Material</label>
                            <select class="form-select" id="urna_material_'.$modo.'" name="urna_material" required>
                                <option value="Madeira" '.($dados && $dados['material'] == 'Madeira' ? 'selected' : '').'>Madeira</option>
                                <option value="Mármore" '.($dados && $dados['material'] == 'Mármore' ? 'selected' : '').'>Mármore</option>
                                <option value="Bronze" '.($dados && $dados['material'] == 'Bronze' ? 'selected' : '').'>Bronze</option>
                                <option value="Aço" '.($dados && $dados['material'] == 'Aço' ? 'selected' : '').'>Aço</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="urna_preco_'.$modo.'" class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" class="form-control" id="urna_preco_'.$modo.'" name="urna_preco" 
                                value="'.($dados ? $dados['preco'] : '').'" required>
                        </div>
                        <button type="submit" class="btn btn-custom">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Urnas</title>
    <link rel="icon" href="./../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .btn-custom {
            background-color: #6c757d;
            color: white;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Lista de Urnas</h1>
    </div>

    <div class="container mt-4">
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= $mensagem ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#criarUrnaModal">Criar</button>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Material</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($lista) > 0): ?>
                    <?php foreach ($lista as $urna): ?>
                        <tr>
                            <td><?= $urna->getUrnaId() ?></td>
                            <td><?= $urna->getUrnaNome() ?></td>
                            <td><?= $urna->getUrnaTipo() ?></td>
                            <td><?= $urna->getUrnaMaterial() ?></td>
                            <td>R$ <?= number_format($urna->getUrnaPreco(), 2, ',', '.') ?></td>
                            <td>
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                    data-bs-target="#editarUrnaModal"
                                    onclick="carregarDadosEdicao(
                                        '<?= $urna->getUrnaId() ?>',
                                        '<?= addslashes($urna->getUrnaNome()) ?>',
                                        '<?= $urna->getUrnaTipo() ?>',
                                        '<?= $urna->getUrnaMaterial() ?>',
                                        '<?= $urna->getUrnaPreco() ?>'
                                    )">
                                    Editar
                                </button>
                                
                                <a href="?excluir=<?= $urna->getUrnaId() ?>" class="btn btn-danger" 
                                    onclick="return confirm('Tem certeza que deseja excluir esta urna?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">Nenhum registro encontrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php 
    exibirModalUrna('criar');
    exibirModalUrna('editar');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function carregarDadosEdicao(id, nome, tipo, material, preco) {
        document.getElementById('editarUrnaModalLabel').textContent = 'Editar Urna - ID: ' + id;
        document.querySelector('#editarUrnaModal input[name="id"]').value = id;
        document.querySelector('#editarUrnaModal input[name="urna_nome"]').value = nome;
        document.querySelector('#editarUrnaModal select[name="urna_tipo"]').value = tipo;
        document.querySelector('#editarUrnaModal select[name="urna_material"]').value = material;
        document.querySelector('#editarUrnaModal input[name="urna_preco"]').value = preco;
    }
    </script>
</body>
</html>