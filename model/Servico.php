<?php

/*
 * classe para servico
 */
Class Servico {

    public $codservico;
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
        return $this->conexao->inserir("servico", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("servico", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("servico", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("servico", $this);
    }
    
    public function optionServico($codigo = NULL, $multiple = false) {
        print_r($codigo);
        $res = $this->conexao->comando("select SQL_CACHE codservico, nome from servico where codempresa = {$_SESSION["codempresa"]} order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            if($multiple == false){
                echo "<option value=''>--Selecione--</option>";
            }
            $array_codigos = explode(',', $codigo);
            
            while ($servico = $this->conexao->resultadoArray($res)) {
    
                if(isset($servico) && $codigo != NULL && ($codigo == $servico["codservico"] || in_array($servico["codservico"], $array_codigos))){
                    echo "<option selected value='{$servico["codservico"]}'>{$servico["nome"]}</option>";
                }else{
                    echo "<option value='{$servico["codservico"]}'>{$servico["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    } 
    
    public function procurar($post) {
        if (isset($post["codservico"]) && $post["codservico"] != NULL && $post["codservico"] != "") {
            $and .= " and servico.codservico = {$post["codservico"]}";
        }
        if (isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != "") {
            $and .= " and servico.nome like '%{$post["nome"]}%'";
        }
        if (isset($post["observacao"]) && $post["observacao"] != NULL && $post["observacao"] != "") {
            $and .= " and servico.observacao like '%{$post["observacao"]}%'";
        }

        $sql = "select DATE_FORMAT(servico.dtcadastro, '%d/%m/%Y') as dtcadastro2,
        servico.codservico, servico.nome, servico.observacao, funcionario.nome as funcionario, servico.dtcadastro, servico.status
        from servico 
        left join pessoa as funcionario on funcionario.codpessoa = servico.codfuncionario  
        where servico.codempresa = {$_SESSION['codempresa']} {$and}
        order by servico.dtcadastro desc";
        return $this->conexao->comando($sql);
    }
}
