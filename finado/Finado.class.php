<?php

class Finado {
    private $finado_id;
    private $finado_nome;
    private $finado_certidao;

    public function __construct($finado_nome, $finado_certidao, $finado_id = null) {
        $this->finado_nome = $finado_nome;
        $this->finado_certidao = $finado_certidao;
        $this->finado_id = $finado_id;
    }

    public function getFinadoId() {
        return $this->finado_id;
    }

    public function setFinadoId($finado_id) {
        $this->finado_id = $finado_id;
    }

    public function getFinadoNome() {
        return $this->finado_nome;
    }

    public function setFinadoNome($finado_nome) {
        $this->finado_nome = $finado_nome;
    }

    public function getFinadoCertidao() {
        return $this->finado_certidao;
    }

    public function setFinadoCertidao($finado_certidao) {
        $this->finado_certidao = $finado_certidao;
    }
}

?>