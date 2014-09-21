<?php

namespace app\modelo\ferramentas\documentos;

include APP_DIR . "modelo/verificadorFormularioAjax.php";
include("resize-class.php");

use \app\modelo as Modelo;

class verificarnovocabecalho extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $formatosPermitidosImagens = array("jpg", "jpeg");
        $tamanhoMaximo = filter_input(INPUT_POST, 'MAX_FILE_SIZE');
        $arquivoImagem = "image-upload";
        $nomeImagem = $_FILES[$arquivoImagem]['name'];
        $tipoImagem = strtolower(obterExtensaoArquivo($nomeImagem));
        $destinoImagem = 'publico/imagens/cabecalho-documentos/';
        $nomeArquivo = "cabecalho.jpg";


        if (!in_array($tipoImagem, $formatosPermitidosImagens)) {
            $this->adicionarMensagemErro("Tipo de imagem inválido.<br/>Utilize apenas arquivos jpg/jpeg");
            $this->abortarExecucao();
        }
        $tamanhoImagem = filesize($_FILES[$arquivoImagem]['tmp_name']);
        if ($tamanhoImagem > APP_MAX_UPLOAD_SIZE) {
            $this->adicionarMensagemErro("Tamanho máximo permitido para a imagem: " . ($tamanhoMaximo / 1024) . " Kb.");
            $this->abortarExecucao();
        }

        $resize = new \ResizeImage($_FILES[$arquivoImagem]['tmp_name']);
        $resize->resizeTo(580, 90, 'exact');
        $imagemCopiada = $resize->saveImage(ROOT . $destinoImagem . $nomeArquivo);


//A linha a baixo era a antiga implementação, quando não se usava redimensionamendo (feito pela classe "resize-class")
//        $imagemCopiada = copy($_FILES[$arquivoImagem]['tmp_name'], ROOT . $destinoImagem . $nomeArquivo);
//Antigo plotador de mensagem, atualmente, feito via ajax
        if (!$imagemCopiada) {
            $this->adicionarMensagemErro("Erro ao mover imagem para a pasta do servidor");
            $this->abortarExecucao();
        }
        $this->adicionarMensagemSucesso("Cabeçalho alterado com sucesso!");
    }

}
