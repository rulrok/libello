<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';

class ControladorEquipamento extends Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {

        $this->renderizar();
    }

    public function acaoVerificarNovo() {

        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->equipamentos = equipamentoDAO::consultar();
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->equipamentos = equipamentoDAO::consultar();
        $this->renderizar();
    }

    public function acaoEditar() {
        if (isset($_GET['equipamentoID']) || isset($_POST['equipamentoID'])) {
            $this->visao->equipamentoID = $_REQUEST['equipamentoID'];
            $equipamento = new Equipamento();
            $equipamento = equipamentoDAO::recuperarEquipamento($this->visao->equipamentoID);

            $this->visao->equipamento = $equipamento->get_nomeEquipamento();
            $this->visao->quantidade = $equipamento->get_quantidade();
            $this->visao->dataEntrada = $equipamento->get_dataEntrada();
            $this->visao->numeroPatrimonio = $equipamento->get_numeroPatrimonio();
        }

        $this->renderizar();
    }
    
    public function acaoVerificarEdicao(){
        $this->renderizar();
    }
    
    public function acaoRemover(){
        $this->renderizar();
    }

}

?>
