<?php

class Urna {
    private $urna_id;
    private $urna_nome;
    private $urna_tipo;
    private $urna_material;
    private $urna_preco;

    public function __construct($urna_nome, $urna_tipo, $urna_material, $urna_preco, $urna_id = null) {
        $this->urna_nome = $urna_nome;
        $this->urna_tipo = $urna_tipo;
        $this->urna_material = $urna_material;
        $this->urna_preco = $urna_preco;
        $this->urna_id = $urna_id;
    }

    public function getUrnaId() {
        return $this->urna_id;
    }

    public function setUrnaId($urna_id) {
        $this->urna_id = $urna_id;
    }

    public function getUrnaNome() {
        return $this->urna_nome;
    }

    public function setUrnaNome($urna_nome) {
        $this->urna_nome = $urna_nome;
    }

    public function getUrnaTipo() {
        return $this->urna_tipo;
    }

    public function setUrnaTipo($urna_tipo) {
        $this->urna_tipo = $urna_tipo;
    }

    public function getUrnaMaterial() {
        return $this->urna_material;
    }

    public function setUrnaMaterial($urna_material) {
        $this->urna_material = $urna_material;
    }

    public function getUrnaPreco() {
        return $this->urna_preco;
    }

    public function setUrnaPreco($urna_preco) {
        $this->urna_preco = $urna_preco;
    }
}

?>