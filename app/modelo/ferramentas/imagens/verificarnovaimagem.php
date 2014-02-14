<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Imagem.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovaimagem extends verificadorFormularioAjax {

    public function _validar() {
        $titulo = $_POST['nome'];
        $descricoes = $_POST['descricoes'];
        $descritor1 = $_POST['descritor1'];
        $descritor2 = $_POST['descritor2'];
        $descritor3 = $_POST['descritor3'];
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];
        $dificuldade = $_POST['dificuldade'];
        $caminhoImagem = $_POST['image_upload'];

        //Vai validar os dados
        try {
            $imagem = new Imagem();

            $imagem->set_titulo($titulo)->set_descricoes($descricoes)->set_descritor1($descritor1)->set_descritor2($descritor2)->set_descritor3($descritor3)->set_dificuldade($dificuldade)->set_caminhoImagem($caminhoImagem);
 
            $this->mensagem->set_mensagem(print_r($imagem,true))->set_status(Mensagem::INFO);
        } catch (Exception $e) {
            //Mensagem de erro gerada pela classe Equipamento.
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
    }

}

$verificar = new verificarnovaimagem();
$verificar->verificar();
?>
