<?php

/*
 * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
 */

Class ImagemManutencao {

    public $codimagem;
    public $imagem;
    public $codmanutencao;
    public $codempresa;
    private $conexao;

    /*
     * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
     */
    public function __construct($conn) {
        $this->conexao = $conn;
    }

    public function __destruct() {
        unset($this);
    }

    public function inserir() {
        if (!isset($this->dtcadastro) || $this->dtcadastro == NULL || $this->dtcadastro == "") {
            $this->dtcadastro = date('Y-m-d H:i:s');
        }
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        return $this->conexao->inserir("imagemmanutencao", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("imagemmanutencao", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("imagemmanutencao", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("imagemmanutencao", $this);
    }

}
