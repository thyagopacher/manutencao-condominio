<?php

/*
 * classe para equipamento
 */
Class Equipamento {

    public $codequipamento;
    private $conexao;
    public $array_periodo = array('1' => 'Diário', '2' => 'Semanal', '3' => 'Mensal', '4' => 'Anual', '5' => 'Dias não sequenciais');

    public function __construct($conn, $codequipamento = '') {
        $this->codequipamento = $codequipamento;
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
        return $this->conexao->inserir("equipamento", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("equipamento", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("equipamento", $this);
    }

    public function procurarCodigo() {
        return $this->conexao->procurarCodigo("equipamento", $this);
    }
    
    public function optionEquipamento($codigo = NULL) {
        $res = $this->conexao->comando("select SQL_CACHE codequipamento, nome, periodo, imagem, codservico from equipamento where codempresa = {$_SESSION["codempresa"]} order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            echo "<option value=''>--Selecione--</option>";
            while ($equipamento = $this->conexao->resultadoArray($res)) {
                if($codigo != NULL && $codigo == $equipamento["codequipamento"]){
                    echo "<option imagem='{$equipamento["imagem"]}' periodo='{$equipamento["periodo"]}' codservico='{$equipamento["codservico"]}' selected value='{$equipamento["codequipamento"]}'>{$equipamento["nome"]}</option>";
                }else{
                    echo "<option imagem='{$equipamento["imagem"]}' periodo='{$equipamento["periodo"]}' codservico='{$equipamento["codservico"]}' value='{$equipamento["codequipamento"]}'>{$equipamento["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    }  
    
    public function procurar($post) {
        if (isset($post["codequipamento"]) && $post["codequipamento"] != NULL && $post["codequipamento"] != "") {
            $and .= " and equipamento.codequipamento = {$post["codequipamento"]}";
        }
        if (isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != "") {
            $and .= " and equipamento.nome like '%{$post["nome"]}%'";
        }
        if (isset($post["status"]) && $post["status"] != NULL && $post["status"] != "") {
            $and .= " and equipamento.status like '%{$post["status"]}%'";
        }        
        if (isset($post["periodo"]) && $post["periodo"] != NULL && $post["periodo"] != "") {
            $and .= " and equipamento.periodo = " .$post["periodo"];
        }
        if (isset($post["codpatrimonio"]) && $post["codpatrimonio"] != NULL && $post["codpatrimonio"] != "") {
            $and .= " and equipamento.codpatrimonio like '%{$post["codpatrimonio"]}%'";
        }
        if (isset($post["qrcode"]) && $post["qrcode"] != NULL && $post["qrcode"] != "") {
            $and .= " and equipamento.qrcode like '%{$post["qrcode"]}%'";
        }            
        if (isset($post["codfornecedor"]) && $post["codfornecedor"] != NULL && $post["codfornecedor"] != "") {
            $and .= " and equipamento.codfornecedor = " .$post["codfornecedor"];
        }
        if (isset($post["codexecutor"]) && $post["codexecutor"] != NULL && $post["codexecutor"] != "") {
            $and .= " and equipamento.codexecutor = " .$post["codexecutor"];
        }
        if (isset($post["codlocal"]) && $post["codlocal"] != NULL && $post["codlocal"] != "") {
            $and .= " and equipamento.codlocal = " .$post["codlocal"];
        }

        $sql = "select DATE_FORMAT(equipamento.dtcadastro, '%d/%m/%Y') as dtcadastro2,
        equipamento.codequipamento, equipamento.nome, equipamento.status, equipamento.periodo, 
        equipamento.qrcode, localequipamento.nome as local,
        funcionario.nome as funcionario, equipamento.dtcadastro, 
        equipamento.imagem,equipamento.descricao, equipamento.codpatrimonio, executor.nome as executor, fornecedor.nome as fornecedor
        from equipamento 
        left join pessoa as funcionario on funcionario.codpessoa = equipamento.codfuncionario  
        inner join executor as executor on executor.codexecutor = equipamento.codexecutor
        inner join executor as fornecedor on fornecedor.codexecutor = equipamento.codfornecedor
        inner join localequipamento on localequipamento.codlocal =  equipamento.codlocal and localequipamento.codempresa =  equipamento.codempresa
        where equipamento.codempresa = {$_SESSION['codempresa']} {$and}
        order by equipamento.dtcadastro desc";  
        return $this->conexao->comando($sql);
    }
       
    
}