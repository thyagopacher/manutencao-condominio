<?php
    function __autoload($class_name) {
        if(file_exists('../model/'.$class_name . '.php')){
            include '../model/'.$class_name . '.php';
        }elseif(file_exists("../visao/".$class_name . '.php')){
            include "../visao/".$class_name . '.php';
        }elseif(file_exists("./".$class_name . '.php')){
            include "./".$class_name . '.php';
        }
    }
    
    session_start();
    
    if(!isset($_SESSION["codempresa"])){
        die(json_encode(array('mensagem' => 'Sua sessão caiu, por favor logue novamente!!!', 'situacao' => false)));
    }    
    
    $conexao = new Conexao();
    $equipamento  = new Equipamento($conexao);
    $equipamento->codequipamento  = $_POST['codequipamento'];

    $inputValue = $_POST["imagem"];
    $nome_arquivo = "image_webcam_equipamento_emp{$_SESSION['codequipamento']}_{$_POST['codequipamento']}".date("YmdHis").".png";
    if (isset($inputValue)) {
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
        } else {
            die(json_encode(array('mensagem' => "Erro ao transferir arquivo para servidor!!!", 'situacao' => false)));
        }
    }

    $equipamentop = $conexao->comandoArray("select nome from equipamento where codequipamento = '{$equipamento->codequipamento}' and codempresa = '{$_SESSION['codempresa']}'");
    $equipamento->imagem = $nome_arquivo;
    $resAtualizarEquipamento = $equipamento->atualizar();
    if($resAtualizarEquipamento !== FALSE){
        $log = new Log($conexao);
        $log->codequipamento  = $_SESSION['codequipamento'];
        $log->acao       = "inserir";
        $log->observacao = "Foto equipamento trocada pela webcam {$equipamentop["nome"]} - em ". date("d/m/Y"). " - ". date("H:i");
        $log->inserir();            
        die(json_encode(array('mensagem' => "Sucesso ao salvar imagem", 'situacao' => true)));
    }else{
        die(json_encode(array('mensagem' => "Erro ao salvar imagem causado por:". mysqli_error($conexao->conexao), 'situacao' => false)));
    }