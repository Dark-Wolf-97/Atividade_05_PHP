<?php
require_once './../velorioService.php';
require_once __DIR__ . '/../../urna/Urna.class.php';
require_once __DIR__ . '/../../urna/urnaService.php';
require_once __DIR__ . '/../../finado/finadoService.php';

$listaUrnas = array();
$listaFinados = array();
$listaVelorios = array();
$mensagem = '';

function listar() {
    global $listaUrnas, $listaFinados, $listaVelorios;
    $urnaService = new UrnaService();
    $finadoService = new FinadoService();
    $velorioService = new VelorioService();
    $listaUrnas = $urnaService->listar();
    $listaFinados = $finadoService->listar();
    $listaVelorios = $velorioService->listar();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $velorioService = new VelorioService();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $velorioService = new VelorioService();
        
        if (isset($_POST['criar'])) {
        
            $result = $velorioService->criar(velorio_data: $_POST['data_velorio'],
             finado_id: $_POST['finado_id'],
             usuario_id: '1',
             urna_id: $_POST['urna_id']);
            
            $mensagem = $result ? 'Velório criado com sucesso!' : 'Erro ao criar velório!';
        }
        
        if (isset($_POST['editar'])) {
            $result = $velorioService->atualizar($_POST['id'], $_POST['data_velorio'], $_POST['finado_id'], '1', $_POST['urna_id']);
            $mensagem = $result ? 'Velório atualizado com sucesso!' : 'Erro ao atualizar velório!';
        }
    }
}

if (isset($_GET['excluir'])) {
    $velorioService = new VelorioService();
    $result = $velorioService->deletar($_GET['excluir']);
    $mensagem = $result ? 'Velório excluído com sucesso!' : 'Erro ao excluir velório!';
}

listar();

function exibirModalVelorio($modo = 'criar', $dados = null) {
    $idModal = ($modo == 'criar') ? 'criarVelorioModal' : 'editarVelorioModal';
    $titulo = ($modo == 'editar') ? 'Criar Velório' : 'Editar Velório';
    echo '<div class="modal fade" id="'.$idModal.'" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">'.$titulo.'</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="'.$modo.'">
                        '.($modo == 'editar' ? '<input type="hidden" name="id" value="'.($dados ? $dados['id'] : '').'">' : '').'
                       
                        <div class="mb-3">
                            <label class="form-label">Finado</label>
                            <select class="form-control" name="finado_id" required>';
                                global $listaFinados;
                                if (empty($listaFinados)) {
                                    echo '<option value="" disabled selected>Nenhum finado registrado</option>';
                                } else {
                                    foreach ($listaFinados as $finado) {
                                        $selected = ($dados && $dados['finado_id'] == $finado->getFinadoId()) ? 'selected' : '';
                                        echo '<option value="'.$finado->getFinadoId().'" '.$selected.'>'.$finado->getFinadoNome().'</option>';
                                    }
                                }
    echo                    '</select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Urna</label>
                            <select class="form-control" name="urna_id" required>';
                                global $listaUrnas;
                                if (empty($listaUrnas)) {
                                    echo '<option value="" disabled selected>Nenhuma urna registrada</option>';
                                } else {
                                    foreach ($listaUrnas as $urna) {
                                        $selected = ($dados && $dados['urna_id'] == $urna->getUrnaId()) ? 'selected' : '';
                                        echo '<option value="'.$urna->getUrnaId().'" '.$selected.'>'.$urna->getUrnaNome().'</option>';
                                    }
                                }
    echo                    '</select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data Velório</label>
                            <input type="date" class="form-control" name="data_velorio" 
                                value="'.($dados ? $dados['data_velorio'] : '').'" 
                                onkeydown="return false" required>
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
    <title>Gerenciamento de Velórios</title>
    <link rel="icon" href="./../../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">    
    <style>
        .btn-custom {
            background-color:rgb(81, 78, 82);
            color: white;
        }
        .header {
            background-color:rgb(203, 202, 204);
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header ">
        <div class="container">
            <div style="text-align:start;">
                <a href="../../index.php" class="btn btn-custom">
                    <- Voltar
                </a>
            </div>
            <h1>Lista de Velórios</h1>
        </div>        
    </div>
    <div class="container mt-4">
    <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= $mensagem ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#criarVelorioModal">Criar</button>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Finado</th>
                    <th>Data Velório</th>
                    <th>Caixão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($listaVelorios)): ?>
                    <tr><td colspan="6" class="text-center">Nenhum velório registrado</td></tr>
                <?php else: ?>
                    <?php foreach ($listaVelorios as $velorio): ?>
                        <tr>
                            <td><?= $velorio->getVelorioId() ?></td>
                            <td><?= $velorio->getFinado()->getFinadoNome() ?></td>
                            <td><?= date('d/m/Y', strtotime($velorio->getVelorioData())) ?></td>
                            <td><?= $velorio->getUrna()->getUrnaTipo() ?></td>
                            <td>
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                    data-bs-target="#editarVelorioModal"
                                    onclick="carregarDadosEdicao(
                                        '<?= $velorio->getVelorioId() ?>',
                                        '<?= $velorio->getFinado()->getFinadoId() ?>',
                                        '<?= $velorio->getVelorioData() ?>',
                                        '<?= $velorio->getUrna()->getUrnaId() ?>'
                                    )">
                                    Editar
                                </button>
                                
                                <a href="?excluir=<?= $velorio->getVelorioId() ?>" class="btn btn-danger" 
                                    onclick="return confirm('Tem certeza que deseja excluir este velório?')">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php 
    exibirModalVelorio('criar');
    exibirModalVelorio('editar');
    ?>

    <script>
    function carregarDadosEdicao(id, finadoId, dataVelorio, urnaId) {
        document.querySelector('#editarVelorioModal input[name="id"]').value = id;
        document.querySelector('#editarVelorioModal select[name="finado_id"]').value = finadoId;
        document.querySelector('#editarVelorioModal select[name="urna_id"]').value = urnaId;
        document.querySelector('#editarVelorioModal input[name="data_velorio"]').value = dataVelorio;
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>