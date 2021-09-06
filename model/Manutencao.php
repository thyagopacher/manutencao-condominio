<?php

/*
 * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
 */

Class Manutencao {

    public $codmanutencao;
    public $imagem;
    public $dtcadastro;
    public $codequipamento;
    public $codempresa;
    private $conexao;
    public $array_tipos = array('p' => "Preventiva", 'c' => 'Corretiva');

    /*
     * classe para envio de e-mails, ela registra no banco de dados e depois um cron envia
     */

    public function __construct($conn) {
        if (!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == "") {
            $this->codfuncionario = $_SESSION["codpessoa"];
        }
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        $this->conexao = $conn;
    }

    public function __destruct() {
        unset($this);
    }

    public function inserir() {
        if (!isset($this->dtcadastro) || $this->dtcadastro == NULL || $this->dtcadastro == "") {
            $this->dtcadastro = date('Y-m-d H:i:s');
        }

        return $this->conexao->inserir("manutencao", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("manutencao", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("manutencao", $this);
    }
    
    public function finalizar() {
        return $this->conexao->comando("update manutencao set codstatus = 3, dtfinalizacao = '".date("Y-m-d H:i:s")."' where codmanutencao = {$this->codmanutencao}");
    }

    public function trocaTipo($valor) {
        switch ($valor) {
            case 'c':
                $valor = "Corretiva";
                break;
            case 'p':
                $valor = "Preventiva";
                break;
        }
        return $valor;
    }

    public function procurar($post) {
        $and = '';
        if (isset($post["qrcode"]) && $post["qrcode"] != NULL && $post["qrcode"] != "") {
            $and .= " and equipamento.qrcode = '{$post["qrcode"]}'";
        }
        if (isset($post["codequipamento"]) && $post["codequipamento"] != NULL && $post["codequipamento"] != "") {
            $and .= " and equipamento.codequipamento = {$post["codequipamento"]}";
        }
        if (isset($post["codlocal"]) && $post["codlocal"] != NULL && $post["codlocal"] != "") {
            $and .= " and equipamento.codlocal = {$post["codlocal"]}";
        }
        if (isset($post["status"]) && $post["status"] != NULL && count($_POST["status"]) >= 1) {
            $and .= " and manutencao.codstatus in (".implode(',', $post["status"]).")";
        }
        if (isset($post["codfornecedor"]) && $post["codfornecedor"] != NULL && $post["codfornecedor"] != "") {
            $and .= " and fornecedor.codexecutor = {$post["codfornecedor"]}";
        }
        if (isset($post["codexecutor"]) && $post["codexecutor"] != NULL && $post["codexecutor"] != "") {
            $and .= " and executor.codexecutor = {$post["codexecutor"]}";
        }
        if (isset($post["tipoExecutor"]) && $post["tipoExecutor"] != NULL && $post["tipoExecutor"] != "") {
            $and .= " and executor.tipo = '{$post["tipoExecutor"]}'";
        }
        if (isset($post["tipo"]) && $post["tipo"] != NULL && $post["tipo"] != "") {
            $and .= " and manutencao.tipo = '{$post["tipo"]}'";
        }
        if (isset($post["data1"]) && $post["data1"] != NULL && $post["data1"] != "") {
            if (strpos($post['data1'], '/')) {
                $data = implode("-", array_reverse(explode('/', $post['data1'])));
            } else {
                $data = $post['data1'];
            }
            $and .= " and manutencao.dtcadastro >= '{$data} 00:00:00'";
        }
        if (isset($post["data2"]) && $post["data2"] != NULL && $post["data2"] != "") {
            if (strpos($post['data2'], '/')) {
                $data = implode("-", array_reverse(explode('/', $post['data2'])));
            } else {
                $data = $post['data2'];
            }
            $and .= " and manutencao.dtcadastro <= '{$data} 00:00:00'";
        }
        if (isset($post["data3"]) && $post["data3"] != NULL && $post["data3"] != "") {
            if (strpos($post['data3'], '/')) {
                $data = implode("-", array_reverse(explode('/', $post['data3'])));
            } else {
                $data = $post['data3'];
            }
            $and .= " and manutencao.data >= '{$data}'";
        }
        if (isset($post["data4"]) && $post["data4"] != NULL && $post["data4"] != "") {
            if (strpos($post['data4'], '/')) {
                $data = implode("-", array_reverse(explode('/', $post['data4'])));
            } else {
                $data = $post['data4'];
            }
            $and .= " and manutencao.data <= '{$data}'";
        }
        if (isset($post["por"]) && $post["por"] != NULL && $post["por"] != "") {
            $and .= " and manutencao.codfuncionario = {$post["por"]}";
        }
        if(isset($_SESSION["codempresa"]) && $_SESSION["codempresa"] != NULL && $_SESSION["codempresa"] != ""){
            $and .= " and manutencao.codempresa = {$_SESSION['codempresa']}";
        }
        $sql = "select DATE_FORMAT(manutencao.dtcadastro, '%d/%m/%Y') as dtcadastro2,
            manutencao.descricao, manutencao.codmanutencao, manutencao.titulo,
            funcionario.nome as funcionario, manutencao.dtcadastro, manutencao.codstatus as statusm,
            status.nome as status, manutencao.valor, manutencao.imginicio, manutencao.imgfim, 
            manutencao.imagem, manutencao.descricao, equipamento.nome as equipamento, manutencao.data, 
            manutencao.tipo, manutencao.datafim, fornecedor.nome as fornecedor, manutencao.valor_gasto,
            DATE_FORMAT(manutencao.data, '%d/%m/%Y') as data2, manutencao.codservico, status.nome as status,
            DATE_FORMAT(manutencao.datafim, '%d/%m/%Y') as datafim2, executor.nome as executor, manutencao.demais_observacoes, 
            manutencao.codempresa, equipamento.periodo
            from manutencao 
            inner join statusmanutencao as status on status.codstatus = manutencao.codstatus 
            inner join pessoa as funcionario on funcionario.codpessoa = manutencao.codfuncionario 
            inner join equipamento on equipamento.codequipamento = manutencao.codequipamento and equipamento.codempresa = manutencao.codempresa
            left join executor as executor on executor.codexecutor = equipamento.codexecutor 
            left join executor as fornecedor on fornecedor.codexecutor = equipamento.codfornecedor
            where 1 = 1 {$and}
            order by manutencao.dtcadastro desc";    
        return $this->conexao->comando($sql);
    }

    public function procurarCodigo($codigo, $colunas = "manutencao.*") {
        $sql = "select SQL_CACHE $colunas
        from manutencao 
        where codempresa = {$_SESSION["codempresa"]} 
        and codmanutencao = {$codigo}";
        return $this->conexao->comandoArray($sql);
    }

}
