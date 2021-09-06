<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ThyagoHenrique
 */
interface IPersistencia {

    public function inserir();
    public function atualizar();
    public function excluir();
    public function procurarCodigo();
    public function procurar($post, $colunas = '*');
    
}
