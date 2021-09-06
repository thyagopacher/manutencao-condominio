<?php

Class Log {

    public $codlog;
    public $codpessoa;
    public $data;
    public $hora;
    public $codpagina;
    public $codempresa;
    public $acao; /*     * ('inserir', 'atualizar', 'excluir') */
    public $observacao;
    private $conexao;

    public function __construct($conn, $observacao = NULL) {
        $this->conexao = $conn;
        if (isset($observacao) && $observacao != NULL && $observacao != "") {
            $this->observacao = $observacao;
            $this->inserir("log", $this);
        }
    }

    public function __destruct() {
        unset($this);
    }

    public function inserir() {
        if (!isset($this->data) || $this->data == NULL || $this->data == "") {
            $this->data = date("Ymd");
        }
        if (!isset($this->hora) || $this->hora == NULL || $this->hora == "") {
            $this->hora = date('H:i:s');
        }
        if (!isset($this->enderecoip) || $this->enderecoip == NULL || $this->enderecoip == "") {
            $this->enderecoip = $this->get_client_ip();
        }
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        if (!isset($this->codpessoa) || $this->codpessoa == NULL || $this->codpessoa == "") {
            $this->codpessoa = $_SESSION["codpessoa"];
        }
        if (!isset($this->acao) || $this->acao == NULL || $this->acao == "") {
            $this->acao = 'inserir';
        }
        if (!isset($this->observacao) || $this->observacao == NULL || $this->observacao == "") {
            $this->observacao = print_r($_POST);//na pior das hipoteses o log guarda pelo menos o post
        }
        return $this->conexao->inserir("log", $this);
    }

    public function atualizar() {
        return $this->conexao->atualizar("log", $this);
    }

    public function excluir() {
        return $this->conexao->excluir("log", $this);
    }

    public function procuraCodigo() {
        return $this->conexao->procurarCodigo("log", $this);
    }

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != NULL && $_SERVER['HTTP_CLIENT_IP'] != "") {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if ($_SERVER['HTTP_X_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if ($_SERVER['HTTP_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if ($_SERVER['HTTP_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if ($_SERVER['REMOTE_ADDR']) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function procurar($post, $colunas = 'log.*') {
        $and = "";
        if(isset($post["data1"]) && $post["data1"] != NULL && $post["data1"] != ""){
            if(strstr($post["data1"], '/') != FALSE){
                $post["data1"] = implode("-",array_reverse(explode("/", $post["data1"])));
            }
            $and .= " and log.dtcadastro >= '{$post["data1"]} 00:00:00'";
        }
        if(isset($post["data2"]) && $post["data2"] != NULL && $post["data2"] != ""){
            if(strstr($post["data2"], '/') != FALSE){
                $post["data2"] = implode("-",array_reverse(explode("/", $post["data2"])));
            }
            $and .= " and log.dtcadastro <= '{$post["data2"]} 23:59:59'";
        }
        if(isset($post["enderecoip"]) && $post["enderecoip"] != NULL && $post["enderecoip"] != ""){
            $and .= " and log.enderecoip LIKE '%{$post["enderecoip"]}%'";
        }
   
        if(isset($post["codpessoa"]) && $post["codpessoa"] != NULL && $post["codpessoa"] != ""){
            $and .= " and log.codpessoa = '{$post["codpessoa"]}'";
        }
        $sql = "select $colunas, pessoa.nome as pessoa, pessoa.cpf, pessoa.email, nivel.nome as nivel
        from log 
        inner join pessoa on pessoa.codpessoa = log.codpessoa
        inner join nivel on nivel.codnivel = pessoa.codnivel
        where 1 = 1 $and";
  
        return $this->conexao->comando($sql);
    }
}
