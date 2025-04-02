<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
	<link rel='stylesheet'href='style.css'>
    <style>
        .btn-custom {
            background-color:rgb(81, 78, 82);
            color: white;
        }
        .purple {
            background-color:rgb(203, 202, 204);
        }
    </style>
</head>
<body class="purple">
    <?php
    session_start();
    if (!isset($_SESSION['logado'])) $_SESSION['logado'] = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header("Location: finado/view/Finado.php");
        exit(); 
    }
    ?>

    <div class="auth-container text-center" style="">
        <h1 class="mb-4">Sistema de Gerenciamento</h1>
        
        <?php if($_SESSION['logado']): ?>
            <div class="d-flex justify-content-center gap-3">
                <a href="finado/view/Finado.php" class="btn btn-custom">Finados</a>
                <a href="urna/view/urna.php" class="btn btn-custom">Urnas</a>
                <a href="velorio/view/Velorio.php" class="btn btn-custom">Velórios</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn btn-custom">Entrar</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>