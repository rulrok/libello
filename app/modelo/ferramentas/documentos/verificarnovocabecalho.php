<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include APP_DIR . "visao/verificadorFormularioAjax.php";
include("resize-class.php");

class verificarnovocabecalho extends verificadorFormularioAjax {

    public function _validar() {
        $formatosPermitidosImagens = array("jpg", "jpeg");
        $tamanhoMaximo = filter_input(INPUT_POST, 'MAX_FILE_SIZE');
        $arquivoImagem = "image-upload";
        $nomeImagem = $_FILES[$arquivoImagem]['name'];
        $tipoImagem = strtolower(obterExtensaoArquivo($nomeImagem));
        $destinoImagem = 'publico/imagens/cabecalho-documentos/';
        $nomeArquivo = "cabecalho.jpg";


        if (!in_array($tipoImagem, $formatosPermitidosImagens)) {
            $this->mensagemErro("Tipo de imagem inválido.<br/>Utilize apenas arquivos jpg/jpeg");
        }
        $tamanhoImagem = filesize($_FILES[$arquivoImagem]['tmp_name']);
        if ($tamanhoImagem > APP_MAX_UPLOAD_SIZE) {
            $this->mensagemErro("Tamanho máximo permitido para a imagem: " . ($tamanhoMaximo / 1024) . " Kb.");
        }
        
        $resize = new ResizeImage($_FILES[$arquivoImagem]['tmp_name']);
        $resize->resizeTo(580, 90, 'exact');
        $imagemCopiada = $resize->saveImage(ROOT . $destinoImagem . $nomeArquivo);
        
        
//A linha a baixo era a antiga implementação, quando não se usava redimensionamendo (feito pela classe "resize-class")
//        $imagemCopiada = copy($_FILES[$arquivoImagem]['tmp_name'], ROOT . $destinoImagem . $nomeArquivo);

//Antigo plotador de mensagem, atualmente, feito via ajax
        if (!$imagemCopiada) {
            $this->mensagemErro("Erro ao mover imagem para a pasta do servidor");
        }
        $this->mensagemSucesso("Cabeçalho alterado com sucesso!");
    }

}

$verificar = new verificarnovocabecalho();
$verificar->verificar();
