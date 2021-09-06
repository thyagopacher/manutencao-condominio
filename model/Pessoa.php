<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Pessoa {

    public $codpessoa;
    public $nome;
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
        if (!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == "") {
            $this->codempresa = $_SESSION["codempresa"];
        }
        if (!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == "") {
            $this->codfuncionario = $_SESSION["codpessoa"];
        }
        $this->senha = base64_encode($this->senha);
        return $this->conexao->inserir("pessoa", $this);
    }

    public function atualizar() {
        if(isset($this->senha) && $this->senha != NULL && $this->senha != ""){
            $this->senha = base64_encode($this->senha);
        }
        return $this->conexao->atualizar("pessoa", $this);
    }
    
    public function salvar() {
        $sql = "select SQL_CACHE codpessoa from pessoa where nome = '{$this->nome}' and codempresa = {$_SESSION["codempresa"]}";
        $pessoap = $this->conexao->comandoArray($sql);
        if(isset($pessoap["codpessoa"]) && $pessoap["codpessoa"] != NULL && $pessoap["codpessoa"] != ""){
            return $this->conexao->atualizar("pessoa", $this);
        }else{
            return $this->conexao->inserir("pessoa", $this);
        }
    }    

    public function excluir() {
        return $this->conexao->excluir("pessoa", $this);
    }

    public function procurarCodigo() {
        return $this->conexao->procurarCodigo('pessoa', $this);
    }
    
    public function inativar() {
        return $this->conexao->comando("update pessoa set status = 'i' where status <> 'i' and codpessoa = {$this->codpessoa} and codempresa = {$_SESSION["codempresa"]}");
    }
    
    public function procurarEmail() {
        if(isset($this->codempresa) && $this->codempresa != NULL && $this->codempresa != ""){
            $and = " and codempresa = {$this->codempresa}";
        }
        return $this->conexao->comando('select codpessoa, nome, codempresa, morador, acessapainel, senha from pessoa where email = "'.$this->email.'"'. $and);
    }

    public function login() {
        $and = '';
        if(isset($this->codempresa) && $this->codempresa != NULL && $this->codempresa != ""){
            $and = " and pessoa.codempresa = ".$this->codempresa;
        }
        $sql = 'select pessoa.codpessoa, pessoa.nome, pessoa.codnivel, 
        pessoa.codempresa, pessoa.imagem, pessoa.status, pessoa.acessapainel, pessoa.dtcadastro, nivel.nome as nivel, pessoa.dtcadastro    
        from pessoa 
        inner join nivel on nivel.codnivel = pessoa.codnivel
        where pessoa.email = "'.addslashes(trim($this->email)).'" 
        and pessoa.senha = "'.base64_encode(trim($this->senha)).'" 
        '.$and.' and pessoa.status = "a"';
       
        
        return $this->conexao->comandoArray($sql);
    }

    public function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }

    public function validaCPF() {
        $this->cpf = str_replace('.', "", str_replace('-', '', $this->cpf));
        if (!empty($this->cpf) && strlen(trim($this->cpf)) == 11) {
            $this->cpf = str_pad(preg_replace("/[^0-9]/", "", $this->cpf), 11, '0', STR_PAD_LEFT);
            if ($this->cpf != '00000000000' && $this->cpf != '11111111111' && 
                    $this->cpf != '22222222222' && $this->cpf != '33333333333' && $this->cpf != '44444444444' && $this->cpf != '55555555555' && 
                    $this->cpf != '66666666666' && $this->cpf != '77777777777' && $this->cpf != '88888888888' && $this->cpf != '99999999999') {
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $this->cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($this->cpf{$c} != $d) { return false;}
                }
                return true;
            }
        }
    }

    public function geraSenha($tamanho = 8) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $retorno = '';
        $caracteres = '';
        $caracteres .= $lmin;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }
    
    public function criarFotoData(){
        $inputValue = $this->imagem;
        if (isset($inputValue)) {
            $nome_arquivo = "image_camphone_pessoa_emp{$this->codempresa}_{$this->codmorador}".date("Ymd").'.png';
            if (strpos($inputValue, "data:image/png;base64,") === 0) {
                $fd = fopen("../arquivos/{$nome_arquivo}", "wb");
                $data = base64_decode(substr($inputValue, strlen("data:image/png;base64,")));
            } else if (strpos($inputValue, "data:image/jpg;base64,") === 0) {
                $fd = fopen("../arquivos/{$nome_arquivo}", "wb");
                $data = base64_decode(substr($inputValue, strlen("data:image/jpg;base64,")));
            }

            if ($fd) {
                fwrite($fd, $data);
                fclose($fd);
                return $nome_arquivo;
            } else {
                die(json_encode(array('mensagem' => "Erro ao transferir arquivo para servidor!!!", 'situacao' => false)));
            }
        }else{
            die(json_encode(array('mensagem' => "Sem enviar imagem fica complicado converter!", 'situacao' => false)));
        }        
    }    
    
    public function optionPessoa($codigo = NULL) {
        $res = $this->conexao->comando("select SQL_CACHE codpessoa, nome from pessoa where codempresa = '{$_SESSION["codempresa"]}' order by nome");
        $qtd = $this->conexao->qtdResultado($res);
        if ($qtd > 0) {
            echo "<option value=''>--Selecione--</option>";
            while ($pessoa = $this->conexao->resultadoArray($res)) {
                if($codigo != NULL && $codigo == $pessoa["codpessoa"]){
                    echo "<option selected value='{$pessoa["codpessoa"]}'>{$pessoa["nome"]}</option>";
                }else{
                    echo "<option value='{$pessoa["codpessoa"]}'>{$pessoa["nome"]}</option>";
                }
            }
        } else {
            echo "<option value=''>--Nada encontrado--</option>";
        }
    }
    
    public function procurar($post, $colunas = 'pessoa.*') {
        $and = "";
        if(isset($post["data1"]) && $post["data1"] != NULL && $post["data1"] != ""){
            if(strstr($post["data1"], '/') != FALSE){
                $post["data1"] = implode("-",array_reverse(explode("/", $post["data1"])));
            }
            $and .= " and pessoa.dtcadastro >= '{$post["data1"]}'";
        }
        if(isset($post["data2"]) && $post["data2"] != NULL && $post["data2"] != ""){
            if(strstr($post["data2"], '/') != FALSE){
                $post["data2"] = implode("-",array_reverse(explode("/", $post["data2"])));
            }
            $and .= " and pessoa.dtcadastro <= '{$post["data2"]}'";
        }
        if(isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != ""){
            $and .= " and pessoa.nome LIKE '%{$post["nome"]}%'";
        }
        if(isset($post["email"]) && $post["email"] != NULL && $post["email"] != ""){
            $and .= " and pessoa.email LIKE '%{$post["email"]}%'";
        }
        if(isset($post["codfuncionario"]) && $post["codfuncionario"] != NULL && $post["codfuncionario"] != ""){
            $and .= " and pessoa.codfuncionario = '{$post["codfuncionario"]}'";
        }
        if(isset($post["status"]) && $post["status"] != NULL && $post["status"] != ""){
            $and .= " and pessoa.status = '{$post["status"]}'";
        }
        if(isset($post["codcategoria"]) && $post["codcategoria"] != NULL && $post["codcategoria"] != ""){
            $and .= " and pessoa.codcategoria = '{$post["codcategoria"]}'";
        }
        if(isset($post["codnivel"]) && $post["codnivel"] != NULL && $post["codnivel"] != ""){
            $and .= " and pessoa.codnivel = '{$post["codnivel"]}'";
        }
        if(isset($post["codempresa"]) && $post["codempresa"] != NULL && $post["codempresa"] != ""){
            $and .= " and pessoa.codempresa = '{$post["codempresa"]}'";
        }else{
            $and .= " and pessoa.codempresa = '{$_SESSION["codempresa"]}'";
        }
        $sql = "select $colunas, func.nome as pessoa, nivel_func.nome as nivel_func, nivel_pessoa.nome as nivel_pessoa
        from pessoa
        inner join pessoa as func on func.codpessoa = pessoa.codfuncionario
        inner join nivel  as nivel_func on nivel_func.codnivel = func.codnivel
        inner join nivel  as nivel_pessoa on nivel_pessoa.codnivel = pessoa.codnivel
        where 1 = 1 $and";
        return $this->conexao->comando($sql);         
    }    
}
