<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel='stylesheet' href='loginStyle.css'>;
</head>
<body>
    <?php
    session_start();
    require_once 'database.php';
    $pdo = Database::getInstance();

    function login($pdo) {
        $erro = '';

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])){
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = verificarEmail($pdo, $email);

            if($usuario){
                if($senha === $usuario['usuario_senha']){
                    $_SESSION['usuario_id'] = $usuario['usuario_id'];
                    $_SESSION['logado'] = true;
                    header("Location: index.php"); 
                    exit();
                } else {
                    $erro = "Senha incorreta!";
                }
            } else {
                $erro = "Usuário não encontrado!";
            }
        }
        ?>

        <div class="login-container">
            <h2 class="text-center mb-4">Entre na sua conta</h2>
            
            <?php if(!empty($erro)): ?>
                <div class="alert alert-danger"><?= $erro ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-4">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" name="entrar" class="btn btn-custom">Entrar</button>
            </form>
        </div>

        <?php
    }

    function verificarEmail($pdo, $email) {
        $stmt = $pdo->prepare("SELECT usuario_id, usuario_email, usuario_senha 
                               FROM tb_usuario 
                               WHERE usuario_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    login($pdo);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>