<?php

/*
 * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
 */
Class StatusManutencao {

    public $codstatus;
    public $nome;
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
        if (!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == "") {
            $this->codfuncionario = $_SESSION["codpessoa"];
        }
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        return $this->conexao->inserir("statusmanutencao", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("statusmanutencao", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("statusmanutencao", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("statusmanutencao", $this);
    }
    
    public function optionStatus($codigo = NULL, $multiple = false) {
        $res = $this->conexao->comando("select SQL_CACHE codstatus, nome from statusmanutencao order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            if($multiple == false){
                echo "<option value=''>--Selecione--</option>";
            }
            while ($status = $this->conexao->resultadoArray($res)) {
                if($codigo != NULL && $codigo == $status["codstatus"] && strstr($codigo, ',') == FALSE){
                    echo "<option selected value='{$status["codstatus"]}'>{$status["nome"]}</option>";
                }elseif($codigo != NULL && in_array($status["codstatus"], array($codigo)) && strstr($codigo, ',') != FALSE){
                    echo "<option selected value='{$status["codstatus"]}'>{$status["nome"]}</option>";
                }elseif($codigo != NULL && $codigo == "n3" && $status["codstatus"] != 3){
                    echo "<option selected value='{$status["codstatus"]}'>{$status["nome"]}</option>";
                }else{
                    echo "<option value='{$status["codstatus"]}'>{$status["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    }
}
