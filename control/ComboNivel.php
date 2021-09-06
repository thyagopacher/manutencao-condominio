<?php
    session_start();
    include '../model/Conexao.php';    
    $conexao = new Conexao();

    $and = '';
    if(isset($_POST["nome"]) && $_POST["nome"] != NULL && $_POST["nome"] != ''){
        $and .= " and nome like '%{$_POST["nome"]}%'";
    }
    if(isset($_SESSION["codnivel"]) && $_SESSION["codnivel"] != NULL && $_SESSION["codnivel"] != 1){
        $and .= " and codnivel <> '1'";
    }
    
    $sql = "select SQL_CACHE nivel.codnivel, nivel.nome, nivel.status 
    from nivel 
    left join nivelpagina on nivelpagina.codnivel = nivel.codnivel and nivelpagina.codpagina = 4
    where nivel.codempresa = '{$_SESSION['codempresa']}' {$and} 
    order by nivel.nome";
    $res     = $conexao->comando($sql);
    $qtd     = $conexao->qtdResultado($res);
    
    echo '<label>Perfil</label> ';
    echo '<select class="form-control" name="codnivel" id="codnivelPermissao" onchange="escolheCombo()" title="Selecione aqui o nível">';
    if($qtd > 0){
        echo '<option value="">--Selecione--</option>';
        while($nivel = $conexao->resultadoArray($res)){
            echo '<option maximizar_offline="',$nivel["maximizar_offline"],'" visualizar_arquivos="',$nivel["visualizar_arquivos"],'" aparece_telefone="',$nivel["aparece_telefone"],'" aparece_veiculo="',$nivel["aparece_veiculo"],'" horario_login="',$nivel["horario_login"],'" reenviar_login="',$nivel["reenviar_login"],'" visualizar_pessoa="',$nivel["visualizar_pessoa"],'" status_pessoa="',$nivel["status_pessoa"],'" value="',$nivel["codnivel"],'">',$nivel["nome"],'</option>';
        }
    }else{
        echo '<option value="">Nada encontrado!</option>';
    }
    echo '</select><br>';
