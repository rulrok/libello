<?php

namespace app\controlador;

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_DIR . 'modelo/dao/equipamentoDAO.php';
require_once APP_DIR . "modelo/comboboxes/ComboBoxPapeis.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxUsuarios.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPolo.php';
require_once APP_LIBRARY_DIR . "seguranca/criptografia.php";

use \app\modelo as Modelo;
use \app\mvc as MVC;

class ControladorEquipamentos extends MVC\Controlador {

    var $tipoPadrao = "custeio";

    public function acaoNovo() {

        $this->renderizar();
    }

    public function acaoVerificarNovo() {

        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoConsultar_interno() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->equipamentosInternos = (new Modelo\equipamentoDAO())->consultar("nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_externo() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->equipamentosExternos = (new Modelo\equipamentoDAO())->consultarSaidas("nomeEquipamento,quantidadeSaida,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_embaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->visao->equipamentosBaixa = (new Modelo\equipamentoDAO())->consultarBaixas("nomeEquipamento,quantidadeBaixa,dataBaixa,numeroPatrimonio,observacoes");
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->equipamentos = (new Modelo\equipamentoDAO())->consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio,descricao");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        if (filter_has_var(INPUT_GET, 'equipamentoID') || filter_has_var(INPUT_POST, 'equipamentoID')) {
            $idEquipamento = fnDecrypt($_REQUEST['equipamentoID']);
            $equipamentoDAO = new Modelo\equipamentoDAO();
            $this->visao->equipamentoEditavel = $equipamentoDAO->equipamentoPodeTerTipoAlterado($idEquipamento);
            $this->visao->equipamentoID = $_REQUEST['equipamentoID'];
            $equipamento = $equipamentoDAO->recuperarEquipamento($idEquipamento);
            if (is_null($equipamento)) {
                $this->adicionarMensagemErro("Esse equipamento não existe mais.", true);
                $this->abortarExecucao();
            }
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
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRetorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->saidas = (new Modelo\equipamentoDAO())->consultarSaidas("idSaida, nomeEquipamento, numeroPatrimonio, concat_ws(' ',PNome,UNome) AS `responsavel`,destino,nomePolo,quantidadeSaida,dataSaida");
        /*
         * 0 - idSaída
         * 1 - nomeEquipamento
         * 2 - númeroPatrimônio
         * 3 - responsável
         * 4 - destino
         * 5 - nomePolo
         * 6 - qtdSaída
         * 7 - dataSaída
         */
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            if ($value[4] == null) {
                $value[4] = '';
            }
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovoretorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'saidaID') || filter_has_var(INPUT_POST, 'saidaID')) {
            $idSaida = fnDecrypt($_REQUEST['saidaID']);
            $equipamentoDAO = new Modelo\equipamentoDAO();
            $saida = $equipamentoDAO->recuperarSaidaEquipamento($idSaida);
            if (is_null($saida)) {
                $this->adicionarMensagemErro("Esse equipamento provavelmente já foi retornado.");
                $this->abortarExecucao();
            }
            $equipamentoID = $saida['equipamento'];
            $equipamento = $equipamentoDAO->recuperarEquipamento($equipamentoID, true);
            if (is_null($equipamento)) {
                $this->adicionarMensagemErro("Esse equipamento não existe mais.", true);
                $this->abortarExecucao();
            }
            $this->visao->saidaID = fnEncrypt($idSaida);
            $this->visao->equipamentoID = fnEncrypt($equipamentoID);
            $this->visao->equipamento = $equipamento;
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->dataSaida = $saida['dataSaida'];
            $this->renderizar();
        } else {
            $this->adicionarMensagemErro("ID não informado", true);
            $this->abortarExecucao();
        }
    }

    public function acaoRegistrarretorno() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoSaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->equipamentos = (new Modelo\equipamentoDAO())->consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio", "quantidade > 0");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovasaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        if (filter_has_var(INPUT_GET, 'equipamentoID')) {
            $this->visao->comboboxPapeis = Modelo\ComboBoxPapeis::montarTodosPapeis();
            $this->visao->equipamento = (new Modelo\equipamentoDAO())->recuperarEquipamento(fnDecrypt(filter_input(INPUT_GET, 'equipamentoID')));
            if (is_null($this->visao->equipamento)) {
                $this->adicionarMensagemErro("Esse equipamento não existe mais.", true);
                $this->abortarExecucao();
            }
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->responsavel = Modelo\ComboBoxUsuarios::listarTodosUsuarios();
            $this->visao->polos = Modelo\ComboBoxPolo::montarTodosOsPolos();
            $this->renderizar();
        } else {
            $this->adicionarMensagemErro("ID não informado", true);
            $this->abortarExecucao();
        }
    }

    public function acaoRegistrarsaida() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoListarusuarios() {
        $this->visao->acessoMinimo = Modelo\Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovabaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'equipamentoID')) {
            $equipamentoDAO = new Modelo\equipamentoDAO();
            $equipamento = $equipamentoDAO->recuperarEquipamento(fnDecrypt(filter_input(INPUT_GET, 'equipamentoID')));
            if (is_null($equipamento)) {
                $this->adicionarMensagemErro("Esse equipamento não existe mais.", true);
                $this->abortarExecucao();
            }
            $this->visao->equipamento = $equipamento;
            $this->visao->dataMinima = $equipamento->get_dataEntrada();
            if ($this->visao->dataMinima == "") {
                $this->visao->dataMinima = "01/01/1900";
            }
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->quantidadeMaxima = $equipamento->get_quantidade();
            $this->visao->saidaID = '';
            $this->renderizar();
        } else if (filter_has_var(INPUT_GET, 'saidaID')) {
            $equipamentoDAO = new Modelo\equipamentoDAO();
            $saida = $equipamentoDAO->recuperarSaidaEquipamento(fnDecrypt(filter_input(INPUT_GET, 'saidaID')));
            if (is_null($saida)) {
                $this->adicionarMensagemErro("Essa saída não existe mais.", true);
                $this->abortarExecucao();
            }
            $this->visao->dataMinima = $saida['dataSaida'];
            $this->visao->equipamento = $equipamentoDAO->recuperarEquipamento($saida['equipamento'], true);
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->saidaID = filter_input(INPUT_GET, 'saidaID');
            $this->renderizar();
        } else {
            $this->adicionarMensagemErro("ID não informado", true);
            $this->abortarExecucao();
        }
    }

    public function acaoRegistrarbaixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciarbaixasesaidas() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_baixas() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->visao->baixas = (new Modelo\equipamentoDAO())->consultarBaixas("idBaixa,nomeEquipamento,dataBaixa,quantidadeBaixa,saida,observacoes");
        $i = 0;
        foreach ($this->visao->baixas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->baixas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_baixa() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_saidas() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->visao->saidas = (new Modelo\equipamentoDAO())->consultarSaidas("idSaida,nomeEquipamento,dataSaida,quantidadeSaidaOriginal,concat_ws(' ',PNome,UNome) as `responsavel`");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_saida() {
        $this->visao->acessoMinimo = Modelo\Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::CONTROLE_EQUIPAMENTOS;
    }

}

?>
