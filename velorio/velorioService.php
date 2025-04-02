<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/Velorio.class.php';

class VelorioService {
    public function listar() {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM tb_velorio v 
                               JOIN tb_finado f ON v.finado_id = f.finado_id
                               JOIN tb_urna u ON v.urna_id = u.urna_id');
        $stmt->execute();
        $resposta = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $finado = new Finado($row['finado_nome'], $row['finado_certidão'], $row['finado_id']);
            $urna = new Urna($row['urna_nome'], $row['urna_tipo'], $row['urna_material'], $row['urna_preco'], $row['urna_id']);
            $resposta[] = new Velorio($row['velorio_data'], $finado, $row['usuario_id'], $urna, $row['velorio_id']);
        }
        return $resposta;
    }

    public function criar($velorio_data,  int $finado_id, int $usuario_id, int $urna_id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO tb_velorio (velorio_data, finado_id, usuario_id, urna_id) 
                               VALUES (:velorio_data, :finado_id, :usuario_id, :urna_id)");
        $stmt->bindParam(':velorio_data', $velorio_data);
        $stmt->bindParam(':finado_id', $finado_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':urna_id', $urna_id);
        return $stmt->execute() ? 'Sucesso' : 'Erro';
    }

    public function deletar($id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM tb_velorio WHERE velorio_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function atualizar($id, $velorio_data, $finado_id, $usuario_id, $urna_id) {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE tb_velorio SET 
                               velorio_data = :velorio_data,
                               finado_id = :finado_id,
                               usuario_id = :usuario_id,
                               urna_id = :urna_id
                               WHERE velorio_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':velorio_data', $velorio_data);
        $stmt->bindParam(':finado_id', $finado_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':urna_id', $urna_id);
        return $stmt->execute();
    }
}
?>
