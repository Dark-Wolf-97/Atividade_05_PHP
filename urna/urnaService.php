<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/Urna.class.php';

class UrnaService {
    public function listar() {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM tb_urna');
        $stmt->execute();
        $resposta = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resposta[] = new Urna(
                $row['urna_nome'],
                $row['urna_tipo'],
                $row['urna_material'],
                $row['urna_preco'],
                $row['urna_id']
            );
        }
        return $resposta;
    }

    public function criar($nome, $tipo, $material, $preco) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tb_urna (urna_nome, urna_tipo, urna_material, urna_preco) 
                              VALUES (:nome, :tipo, :material, :preco)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':material', $material);
        $stmt->bindParam(':preco', $preco);
        return $stmt->execute() ? 'Sucesso' : 'Erro';
    }

    public function deletar($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM tb_urna WHERE urna_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar($id, $nome, $tipo, $material, $preco) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE tb_urna SET 
                              urna_nome = :nome, 
                              urna_tipo = :tipo, 
                              urna_material = :material, 
                              urna_preco = :preco 
                              WHERE urna_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':material', $material);
        $stmt->bindParam(':preco', $preco);
        return $stmt->execute();
    }
}
?>