<?php

/*
 * classe para empresa
 */

Class Empresa{

    public $codempresa;
    private $conexao;

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
        return $this->conexao->inserir("empresa", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("empresa", $this);
    }
    public function salvar() {
        $empresap = $this->conexao->comandoArray("select SQL_CACHE codempresa from empresa where razao = '{$this->razao}'");
        if(isset($empresap["codempresa"]) && $empresap["codempresa"] != NULL && $empresap["codempresa"] != ""){
            return $this->conexao->atualizar("empresa", $this);
        }else{
            return $this->conexao->inserir("empresa", $this);
        }
    }

    public function excluir() {
        return $this->conexao->excluir("empresa", $this);
    }

    public function procurarCodigo($colunas = "*") {
        return $this->conexao->comandoArray("select SQL_CACHE $colunas from empresa where codempresa = {$_SESSION["codempresa"]}");
    }
    

    public function procurar($post, $colunas = 'empresa.*') {
        $and = "";
        if(isset($post["data1"]) && $post["data1"] != NULL && $post["data1"] != ""){
            if(strstr($post["data1"], '/') != FALSE){
                $post["data1"] = implode("-",array_reverse(explode("/", $post["data1"])));
            }
            $and .= " and empresa.dtcadastro >= '{$post["data1"]}'";
        }
        if(isset($post["data2"]) && $post["data2"] != NULL && $post["data2"] != ""){
            if(strstr($post["data2"], '/') != FALSE){
                $post["data2"] = implode("-",array_reverse(explode("/", $post["data2"])));
            }
            $and .= " and empresa.dtcadastro <= '{$post["data2"]}'";
        }
        if(isset($post["razao"]) && $post["razao"] != NULL && $post["razao"] != ""){
            $and .= " and empresa.razao LIKE '%{$post["enderecoip"]}%'";
        }
        if(isset($post["email"]) && $post["email"] != NULL && $post["email"] != ""){
            $and .= " and empresa.email like '%{$post["email"]}%'";
        }
        if(isset($post["site"]) && $post["site"] != NULL && $post["site"] != ""){
            $and .= " and empresa.site LIKE '%{$post["site"]}%'";
        }
        if(isset($post["bairro"]) && $post["bairro"] != NULL && $post["bairro"] != ""){
            $and .= " and empresa.bairro like '%{$post["bairro"]}%'";
        }
        if(isset($post["status"]) && $post["status"] != NULL && $post["status"] != ""){
            $and .= " and empresa.status = '{$post["status"]}'";
        }
        $sql = "select $colunas, pessoa.nome as pessoa, nivel.nome as nivel, status.nome as status
        from empresa 
        inner join pessoa on pessoa.codpessoa = empresa.codpessoa
        inner join statusempresa as status on status.codstatus = empresa.codstatus
        inner join nivel on nivel.codnivel = pessoa.codnivel
        where 1 = 1 $and";
        return $this->conexao->comando($sql);        
    }

}
