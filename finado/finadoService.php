<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/Finado.class.php';

class FinadoService {
    public function listar() {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM tb_finado');
        $stmt->execute();
        $resposta = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resposta[] = new Finado($row['finado_nome'], $row['finado_certidão'], $row['finado_id']);
        }
        return $resposta;
    }

    public function criar($nome, int $certidao) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tb_finado (finado_nome, finado_certidão) VALUES (:nome, :certidao)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':certidao', $certidao);
        return $stmt->execute() ? 'Sucesso' : 'Erro';
    }

    public function deletar($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM tb_finado WHERE finado_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar($id, $nome, $certidao) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE tb_finado SET finado_nome = :nome, finado_certidão = :certidao WHERE finado_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':certidao', $certidao);
        return $stmt->execute();
    }
}
?>
