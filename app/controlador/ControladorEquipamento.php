<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorEquipamento extends Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {
//        if (!$erro) {
//            $this->visao->equipamento = "";
//            $this->visao->dataEntrada = "";
//            $this->visao->quantidade = "";
//            $this->visao->numeroPatrimonio = "";
//            $this->visao->tipoPadrao = $this->tipoPadrao;
//            $this->visao->tipo = $this->visao->tipoPadrao;
//        }
        $this->renderizar();
    }

    public function acaoVerificarNovo() {
//        return true;
//        exit;
//        $this->visao->mensagem_usuario = null;
//        $this->visao->tipo_mensagem = null;
//        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
//            $_SERVER['REQUEST_METHOD'] = null;
//        endif;
//        $this->visao->tipoPadrao = $this->tipoPadrao;
//        $this->visao->equipamento = $_POST['equipamento'];
//        $this->visao->dataEntrada = $_POST['dataEntrada'];
//        $this->visao->quantidade = $_POST['quantidade'];
//        $this->visao->tipo = $_POST['tipo'];
//        if (isset($_POST['numeroPatrimonio']))
//            $this->visao->numeroPatrimonio = $_POST['numeroPatrimonio'];
//        else
//            $this->visao->numeroPatrimonio = "";
//
//        print_r($_POST);

        $this->renderizar();
    }

}

?>
