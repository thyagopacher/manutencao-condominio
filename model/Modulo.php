<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Modulo{
    
    public $codmodulo;
    public $inserir;
    public $atualizar;
    public $excluir;
    public $procurar;
    public $mostrar;
    private $conexao;
    
    public function __construct($conn) {
        $this->conexao = $conn;
    }
    
    public function __destruct() {
        unset($this);
    }     
    
    public function inserir(){
        if(!isset($this->codempresa) || $this->codempresa == NULL || $this->codempresa == ""){
            $this->codempresa = $_SESSION["codempresa"];
        }
        return $this->conexao->inserir('modulo', $this);
    }
    
    public function atualizar(){
        return $this->conexao->atualizar('modulo', $this);
    }  
    
    public function excluir(){
        return $this->conexao->excluir('modulo', $this);
    }
    
    public function procuraCodigo(){
        return $this->conexao->procurarCodigo('modulo', $this);
    }

}