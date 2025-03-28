<?php
require_once './../finadoService.php';

$lista = array();
$mensagem = '';

function listar() {
    global $lista;
    $finadoService = new FinadoService();
    $lista = $finadoService->listar();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $finadoService = new FinadoService();
    
    if (isset($_POST['criar'])) {
        $result = $finadoService->criar($_POST['finado_nome'], $_POST['finado_certidao']);
        $mensagem = $result === 'Sucesso' ? 'Finado criado com sucesso!' : 'Erro ao criar finado!';
    }
    
    if (isset($_POST['editar'])) {
        $result = $finadoService->atualizar(
            $_POST['id'],
            $_POST['finado_nome'],
            $_POST['finado_certidao']
        );
        $mensagem = $result ? 'Finado atualizado com sucesso!' : 'Erro ao atualizar finado!';
    }
}

if (isset($_GET['excluir'])) {
    $finadoService = new FinadoService();
    $result = $finadoService->deletar($_GET['excluir']);
    $mensagem = $result ? 'Finado excluído com sucesso!' : 'Erro ao excluir finado!';
}

listar();

function exibirModalFinado($modo = 'criar', $dados = null) {
    $idModal = ($modo == 'criar') ? 'criarFinadoModal' : 'editarFinadoModal';
    $titulo = ($modo == 'criar') ? 'Criar Finado' : 'Editar Finado';
    
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
                            <label for="finado_nome_'.$modo.'" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="finado_nome_'.$modo.'" name="finado_nome" 
                                value="'.($dados ? $dados['nome'] : '').'" required>
                        </div>
                        <div class="mb-3">
                            <label for="finado_certidao_'.$modo.'" class="form-label">Certidão</label>
                            <input type="number" class="form-control" id="finado_certidao_'.$modo.'" name="finado_certidao" 
                                value="'.($dados ? $dados['certidao'] : '').'" required>
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
    <title>Finados</title>
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
        <h1>Lista de Finados</h1>
    </div>

    <div class="container mt-4">
        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= $mensagem ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#criarFinadoModal">Criar</button>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Certidão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($lista) > 0): ?>
                    <?php foreach ($lista as $finado): ?>
                        <tr>
                            <td><?= $finado->getFinadoId() ?></td>
                            <td><?= $finado->getFinadoNome() ?></td>
                            <td><?= $finado->getFinadoCertidao() ?></td>
                            <td>
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                    data-bs-target="#editarFinadoModal"
                                    onclick="carregarDadosEdicao(
                                        '<?= $finado->getFinadoId() ?>',
                                        '<?= addslashes($finado->getFinadoNome()) ?>',
                                        '<?= $finado->getFinadoCertidao() ?>'
                                    )">
                                    Editar
                                </button>
                                
                                <a href="?excluir=<?= $finado->getFinadoId() ?>" class="btn btn-danger" 
                                    onclick="return confirm('Tem certeza que deseja excluir este finado?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Nenhum registro encontrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php 
    exibirModalFinado('criar');
    exibirModalFinado('editar');
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function carregarDadosEdicao(id, nome, certidao) {
        document.getElementById('editarFinadoModalLabel').textContent = 'Editar Finado - ID: ' + id;
        document.querySelector('#editarFinadoModal input[name="id"]').value = id;
        document.querySelector('#editarFinadoModal input[name="finado_nome"]').value = nome;
        document.querySelector('#editarFinadoModal input[name="finado_certidao"]').value = certidao;
    }
    </script>
</body>
</html>