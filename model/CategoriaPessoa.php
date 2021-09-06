<?php

/* 
 * @author Thyago Henrique Pacher - thyago.pacher@gmail.com
 */
include_once "IPersistencia.php";

Class CategoriaPessoa implements IPersistencia{
    
    public $codcategoria;
    public $nome;
    public $dtcadastro;
    public $imagem;
    public $chaveprimaria = "codcategoria";
    private $conexao;
    
    public function __construct($conexao) {
        $this->conexao = $conexao;
    }
    
    public function __destruct() {
        unset($this);
    }     
    
    public function inserir(){
        if(!isset($this->dtcadastro) || $this->dtcadastro == NULL || $this->dtcadastro == ""){
            $this->dtcadastro = date("Y-m-d H:i:s");
        }         
        if(!isset($this->codfuncionario) || $this->codfuncionario == NULL || $this->codfuncionario == ""){
            $this->codfuncionario = $_SESSION["codpessoa"];
        }         
        return $this->conexao->inserir('categoriapessoa', $this);
    }

    public function atualizar(){      
        return $this->conexao->atualizar('categoriapessoa', $this);
    }

    public function procurarCodigo(){
        return $this->conexao->procurarCodigo('categoriapessoa', $this);
    }
    
    public function excluir(){
        return $this->conexao->excluir('categoriapessoa', $this);
    }

    public function procurar($post, $colunas = 'categoria.*') {
        $and = "";
        if(isset($post["data1"]) && $post["data1"] != NULL && $post["data1"] != ""){
            if(strstr($post["data1"], '/') != FALSE){
                $post["data1"] = implode("-",array_reverse(explode("/", $post["data1"])));
            }
            $and .= " and categoria.dtcadastro >= '{$post["data1"]}'";
        }
        if(isset($post["data2"]) && $post["data2"] != NULL && $post["data2"] != ""){
            if(strstr($post["data2"], '/') != FALSE){
                $post["data2"] = implode("-",array_reverse(explode("/", $post["data2"])));
            }
            $and .= " and categoria.dtcadastro <= '{$post["data2"]}'";
        }
        if(isset($post["nome"]) && $post["nome"] != NULL && $post["nome"] != ""){
            $and .= " and categoria.nome LIKE '%{$post["nome"]}%'";
        }
        if(isset($post["codfuncionario"]) && $post["codfuncionario"] != NULL && $post["codfuncionario"] != ""){
            $and .= " and categoria.codfuncionario = '{$post["codfuncionario"]}'";
        }
        $sql = "select $colunas, pessoa.nome as pessoa, nivel.nome as nivel
        from categoriapessoa as categoria 
        inner join pessoa on pessoa.codpessoa = categoria.codfuncionario
        inner join nivel on nivel.codnivel = pessoa.codnivel
        where 1 = 1 $and";
        return $this->conexao->comando($sql);           
    } 

    public function optionCategoria($codigo = NULL){
        $rescategoria = $this->conexao->comando("select codcategoria, nome from categoriapessoa order by nome");
        $qtdcategoria = $this->conexao->qtdResultado($rescategoria);
        if($qtdcategoria > 0){
            echo '<option value="">--Selecione--</option>';
            while($categoriap = $this->conexao->resultadoArray($rescategoria)){
                if($codigo == $categoriap["codcategoria"]){
                    echo '<option selected value="',$categoriap["codcategoria"],'">',$categoriap["nome"],'</option>';
                }else{
                    echo '<option value="',$categoriap["codcategoria"],'">',$categoriap["nome"],'</option>';
                }
            }
        }else{
            echo '<option value="">--Nada encontrado--</option>';
        }        
    }    
}