<?php

/*
 * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
 */

Class FilaEmail {

    public $codfila;
    public $codpessoa;
    public $dtcadastro;
    public $codfuncionario;
    public $situacao;
    public $codempresa;
    public $assunto;
    public $texto;
    public $anexo;
    public $tipo;
    public $codpagina;
    public $enviadode;
    public $responder;
    public $codcomunicado;
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
        if (!isset($this->situacao) || $this->situacao == NULL || $this->situacao == "") {
            $this->situacao = "n"; //setando situação padrão para não enviado
        }
        if (!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == "") {
            $this->codfuncionario = $_SESSION["codpessoa"];
        }
        if (!isset($this->codpessoa) || $this->codpessoa == NULL || $this->codpessoa == "") {
            $this->codpessoa = $_SESSION["codpessoa"];
        }
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        $configuracao = $this->conexao->comandoArray("select usafila from configuracao where codempresa = '{$this->codempresa}'");
        $pessoa = $this->conexao->comandoArray("select recebemsg from pessoa where codpessoa = '{$this->codpessoa}'");

        if ((isset($configuracao["usafila"]) && trim($configuracao["usafila"]) == 's')
                || (isset($pessoa["recebemsg"])) && $pessoa["recebemsg"] != NULL && $pessoa["recebemsg"] == "s") {
            return $this->conexao->inserir("filaemail", $this);
        } else {
            return TRUE;
        }
    }

    public function atualizar() {
        return $this->conexao->atualizar("filaemail", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("filaemail", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("filaemail", $this);
    }

}
