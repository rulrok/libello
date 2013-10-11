<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
require_once APP_LOCATION . "modelo/ComboBoxPapeis.php";
require_once APP_LOCATION . "modelo/ComboBoxUsuarios.php";
include_once APP_LOCATION . 'modelo/ComboBoxPolo.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";

class ControladorEquipamentos extends Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {

        $this->renderizar();
    }

    public function acaoVerificarNovo() {

        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->renderizar();
    }

    public function acaoConsultar_interno() {
        $this->visao->equipamentosInternos = equipamentoDAO::consultar("nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_externo() {
        $this->visao->equipamentosExternos = equipamentoDAO::consultarSaidas("nomeEquipamento,quantidadeSaida,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_embaixa() {
        $this->visao->equipamentosBaixa = equipamentoDAO::consultarBaixas("nomeEquipamento,quantidadeBaixa,dataBaixa,numeroPatrimonio,observacoes");
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->equipamentos = equipamentoDAO::consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio,descricao");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        if (isset($_GET['equipamentoID']) || isset($_POST['equipamentoID'])) {
            $idEquipamento = fnDecrypt($_REQUEST['equipamentoID']);
            $this->visao->equipamentoEditavel = equipamentoDAO::equipamentoPodeTerTipoAlterado($idEquipamento);
            $this->visao->equipamentoID = $_REQUEST['equipamentoID'];
            $equipamento = equipamentoDAO::recuperarEquipamento($idEquipamento);

            $this->visao->descricao = $equipamento->get_descricao();
            $this->visao->equipamento = $equipamento->get_nomeEquipamento();
            $this->visao->quantidade = $equipamento->get_quantidade();
            $this->visao->dataEntrada = $equipamento->get_dataEntrada();
            $this->visao->numeroPatrimonio = $equipamento->get_numeroPatrimonio();
        } else {
            die("Acesso indevido");
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicao() {
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->renderizar();
    }

    public function acaoRetorno() {
        $this->visao->saidas = equipamentoDAO::consultarSaidas("idSaida, nomeEquipamento, numeroPatrimonio, concat(PNome,' ',UNome) AS `responsavel`,destino,nomePolo,quantidadeSaida,data");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
            }
        $this->renderizar();
    }

    public function acaoNovoretorno() {
        if (isset($_GET['saidaID']) || isset($_POST['saidaID'])) {
            $idSaida = fnDecrypt($_GET['saidaID']);

            $saida = equipamentoDAO::recuperarSaidaEquipamento($idSaida);

            $equipamentoID = $saida['equipamento'];
            $equipamento = equipamentoDAO::recuperarEquipamento($equipamentoID);

            $this->visao->saidaID = fnEncrypt($idSaida);
            $this->visao->equipamentoID = fnEncrypt($equipamentoID);
            $this->visao->equipamento = $equipamento;
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->dataSaida = $saida['data'];
            $this->renderizar();
        } else {
            die("Acesso indevido");
        }
    }

    public function acaoRegistrarretorno() {
        $this->renderizar();
    }

    public function acaoSaida() {
        $this->visao->equipamentos = equipamentoDAO::consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio", "quantidade > 0");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovasaida() {
        if (isset($_GET['equipamentoID'])) {
            $this->visao->comboboxPapeis = ComboBoxPapeis::montarComboBoxPadrao();
            $this->visao->equipamento = equipamentoDAO::recuperarEquipamento(fnDecrypt($_GET['equipamentoID']));
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->responsavel = ComboBoxUsuarios::montarResponsavelViagem();
            $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarsaida() {
        $this->renderizar();
    }

    public function acaoListarusuarios() {
        $this->renderizar();
    }

    public function acaoNovabaixa() {
        if (isset($_GET['equipamentoID'])) {
            $equipamento = equipamentoDAO::recuperarEquipamento(fnDecrypt($_GET['equipamentoID']));
            $this->visao->equipamento = $equipamento;
            $this->visao->dataMinima = $equipamento->get_dataEntrada();
            if ($this->visao->dataMinima == ""){
                $this->visao->dataMinima = "01/01/1900";
            }
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->quantidadeMaxima = $equipamento->get_quantidade();
            $this->visao->saidaID = '';
            $this->renderizar();
        } else if (isset($_GET['saidaID'])) {
            $saida = equipamentoDAO::recuperarSaidaEquipamento(fnDecrypt($_GET['saidaID']));
            $this->visao->dataMinima = $saida['data '];
            $this->visao->equipamento = equipamentoDAO::recuperarEquipamento($saida['equipamento']);
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->saidaID = $_GET['saidaID'];
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarbaixa() {
        $this->renderizar();
    }

}

?>
