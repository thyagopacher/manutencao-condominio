<?php

/*
 * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
 */

Class LocalManutencao {

    public $codlocal;
    public $local;
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
        if (!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == "") {
            $this->codfuncionario = $_SESSION["codpessoa"];
        }
        return $this->conexao->inserir("localmanutencao", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("localmanutencao", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("localmanutencao", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("localmanutencao", $this);
    }

}
