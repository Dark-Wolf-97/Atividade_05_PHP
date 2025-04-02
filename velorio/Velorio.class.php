<?php
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../finado/Finado.class.php';
require_once __DIR__ . '/../urna/Urna.class.php';

class Velorio {
    private $velorio_id;
    private $velorio_data;
    private $finado;
    private $usuario_id;
    private $urna;

    public function __construct($velorio_data, Finado $finado, $usuario_id, Urna $urna, $velorio_id = null) {
        $this->velorio_data = $velorio_data;
        $this->finado = $finado;
        $this->usuario_id = $usuario_id;
        $this->urna = $urna;
        $this->velorio_id = $velorio_id;
    }

    public function getVelorioId() {
        return $this->velorio_id;
    }

    public function getVelorioData() {
        return $this->velorio_data;
    }

    public function getFinado() {
        return $this->finado;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function getUrna() {
        return $this->urna;
    }
}