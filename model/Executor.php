<?php

/*
 * classe para executor
 */

Class Executor {

    public $codexecutor;
    private $conexao;
    public $tipos = array('e' => 'Empresa', 'p' => 'Particular', 'f' => 'Funcionário');
    public $funcoes = array('e' => 'Executor', 'f' => 'Fornecedor');
    
    public function __construct($conn, $codigo = NULL) {
        $this->conexao = $conn;
        if($codigo != NULL){
            $this->codexecutor = $codigo;
        }
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
        return $this->conexao->inserir("executor", $this);
    }

    public function atualizar() {
        $this->codempresa = $_SESSION["codempresa"];//força codempresa
        return $this->conexao->atualizar("executor", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("executor", $this);
    }

    public function optionTipos($tipoEscolhido = NULL){
        echo "<option value=''>--Selecione--</option>";
        foreach ($this->tipos as $key => $tipo) {
            if($tipoEscolhido != NULL && $tipoEscolhido == $key){
                echo "<option selected value='$key'>$tipo</option>";
            }else{
                echo "<option value='$key'>$tipo</option>";
            }
        }
    }

    public function optionFuncoes($funcaoEscolhido = NULL){
        echo "<option value=''>--Selecione--</option>";
        foreach ($this->funcoes as $key => $funcao) {
            if($funcaoEscolhido != NULL && $funcaoEscolhido == $key){
                echo "<option selected value='$key'>$funcao</option>";
            }else{
                echo "<option value='$key'>$funcao</option>";
            }
        }
    }
    
    /**
     * @param string $funcao f - Fornecedor / e - Executor
     */
    public function optionExecutor($funcao = 'f', $codigo = NULL) {
        $res = $this->conexao->comando("select SQL_CACHE codexecutor, nome from executor where funcao = '{$funcao}' and codempresa = {$_SESSION["codempresa"]} order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            echo "<option value=''>--Selecione--</option>";
            while ($executor = $this->conexao->resultadoArray($res)) {
                if(isset($executor) && $codigo != NULL && $codigo == $executor["codexecutor"]){
                    echo "<option selected value='{$executor["codexecutor"]}'>{$executor["nome"]}</option>";
                }else{
                    echo "<option value='{$executor["codexecutor"]}'>{$executor["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    }

    public function procurar($post) {
        if (isset($post["codexecutor"]) && $post["codexecutor"] != NULL && $post["codexecutor"] != "") {
            $and .= " and executor.codexecutor = {$post["codexecutor"]}";
        }
        if (isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != "") {
            $and .= " and executor.nome like '%{$post["nome"]}%'";
        }
        if (isset($post["tipo"]) && $post["tipo"] != NULL && $post["tipo"] != "") {
            $and .= " and executor.tipo like '%{$post["tipo"]}%'";
        }
        if (isset($post["funcao"]) && $post["funcao"] != NULL && $post["funcao"] != "") {
            $and .= " and executor.funcao like '%{$post["funcao"]}%'";
        }
        if (isset($post["status"]) && $post["status"] != NULL && $post["status"] != "") {
            $and .= " and executor.status = '{$post["status"]}'";
        }

        $sql = "select DATE_FORMAT(executor.dtcadastro, '%d/%m/%Y') as dtcadastro2,
        executor.codexecutor, executor.nome, executor.status, funcionario.nome as funcionario, executor.dtcadastro, executor.imagemexecutor
        from executor 
        left join pessoa as funcionario on funcionario.codpessoa = executor.codfuncionario
        where executor.codempresa = {$_SESSION['codempresa']} {$and}
        order by executor.dtcadastro desc";
        return $this->conexao->comando($sql);
    }

    public function procurarCodigo($colunas = "executor.*") {
        $sql = "select $colunas, empresa.*, empresa.codempresa as codempresa2,
            pessoa.cep as cep_pessoa, pessoa.tipologradouro as tipologradouro_pessoa,
            pessoa.logradouro as logradouro_pessoa, pessoa.numero as numero_pessoa, pessoa.bairro as bairro_pessoa,
            pessoa.cidade as cidade_pessoa, pessoa.uf as uf_pessoa, pessoa.telefone as _pessoa,
            pessoa.celular as celular_pessoa, pessoa.site as site_pessoa, pessoa.skype as skype_pessoa, 
            pessoa.email as email_pessoa, pessoa.codpessoa
        from executor
        left join empresa on empresa.codexecutor = executor.codexecutor
        left join pessoa on pessoa.codexecutor = executor.codexecutor
        where executor.codempresa = {$_SESSION["codempresa"]}
        and executor.codexecutor = {$this->codexecutor}";

        return $this->conexao->comandoArray($sql);
    }

    public function procurarEmpresa($codigo) {
        $sql = "select razao, cnpj, tipologradouro, logradouro, 
            numero, bairro, cidade, uf, cep, telefone, celular, email, logo 
        from empresa 
        where codexecutor = {$codigo}";
        return $this->conexao->comandoArray($sql);
    }

}
