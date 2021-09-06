<?php

class UploadFtp {

    private $ipservidor = '31.220.109.52';
    private $usuario = 'admin_thyago';
    private $senha = 'Brasil1602*';
    public $arquivo;
    public $name;
    public $tmp_name;
    public $erro;

    public function __construct($arquivo = NULL) {
        $this->upload($arquivo);
    }

    public function upload($arquivo = NULL) {
        $retorno = '';
        $conn_id = ftp_connect($this->ipservidor);
        $login_result = ftp_login($conn_id, $this->usuario, $this->senha);

        if ($arquivo != NULL) {
            $this->name = $arquivo["name"];
            $this->tmp_name = $arquivo["tmp_name"];
        }

        $separacao = explode('.', $this->name);
        if (isset($separacao[1]) && $separacao[1] != NULL && $separacao[1] != "") {
            $nome_final = 'arquivo_ftp_data' . date('YmdHis') . '_emp' .$_SESSION["codempresa"] . rand(0, 9) .'.' . $separacao[1];
            if (ftp_put($conn_id, '/public_html/sistema/arquivos/' . $nome_final, $this->tmp_name, FTP_ASCII)) {
                $this->erro = "";
            } else {
                $this->erro = "Ocorreu um problema ao realizar carregamento do arquivo no servidor: {$this->name}\n";
            }
            // close the connection
            ftp_close($conn_id);
            $this->arquivo = $nome_final;
        }
        return $retorno;
    }

}
