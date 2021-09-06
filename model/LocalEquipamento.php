<?php

/*
 * classe para local
 */
Class LocalEquipamento {

    public $codlocal;
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
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        return $this->conexao->inserir("localequipamento", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("localequipamento", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("localequipamento", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("localequipamento", $this);
    }
    
    public function optionLocal($codigo = NULL) {
        $res = $this->conexao->comando("select SQL_CACHE codlocal, nome from localequipamento where codempresa = {$_SESSION["codempresa"]} order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            echo "<option value=''>--Selecione--</option>";
            while ($local = $this->conexao->resultadoArray($res)) {
                if($codigo != NULL && $codigo == $local["codlocal"]){
                    echo "<option selected value='{$local["codlocal"]}'>{$local["nome"]}</option>";
                }else{
                    echo "<option value='{$local["codlocal"]}'>{$local["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    }    
    
    public function procurar($post){
        if (isset($post["codlocal"]) && $post["codlocal"] != NULL && $post["codlocal"] != "") {
            $and .= " and localequipamento.codlocal = {$post["codlocal"]}";
        }
        if (isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != "") {
            $and .= " and localequipamento.nome like '%{$post["nome"]}%'";
        }

        $sql = "select DATE_FORMAT(localequipamento.dtcadastro, '%d/%m/%Y') as dtcadastro2,
        localequipamento.codlocal, localequipamento.nome, funcionario.nome as funcionario, localequipamento.dtcadastro, localequipamento.imagem,
        localequipamento.descricao1, localequipamento.descricao2, localequipamento.descricao3
        from localequipamento 
        left join pessoa as funcionario on funcionario.codpessoa = localequipamento.codfuncionario  
        where localequipamento.codempresa = {$_SESSION['codempresa']} {$and}
        order by localequipamento.dtcadastro desc";     
        return $this->conexao->comando($sql);
    }

    public function procurarCodigo($codigo, $colunas = "localequipamento.*") {
        $sql = "select SQL_CACHE $colunas
        from localequipamento 
        where codempresa = {$_SESSION["codempresa"]} 
        and codlocal = {$codigo}";
        return $this->conexao->comandoArray($sql);
    }
}
