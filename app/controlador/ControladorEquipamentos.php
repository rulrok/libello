<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once APP_DIR . "modelo/comboboxes/ComboBoxPapeis.php";
require_once APP_DIR . "modelo/comboboxes/ComboBoxUsuarios.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxPolo.php';
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
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoConsultar_interno() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->equipamentosInternos = (new equipamentoDAO())->consultar("nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_externo() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->equipamentosExternos = (new equipamentoDAO())->consultarSaidas("nomeEquipamento,quantidadeSaida,dataEntrada,numeroPatrimonio");
        $this->renderizar();
    }

    public function acaoConsultar_embaixa() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->equipamentosBaixa = (new equipamentoDAO())->consultarBaixas("nomeEquipamento,quantidadeBaixa,dataBaixa,numeroPatrimonio,observacoes");
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->equipamentos = (new equipamentoDAO())->consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio,descricao");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        if (filter_has_var(INPUT_GET, 'equipamentoID') || filter_has_var(INPUT_POST, 'equipamentoID')) {
            $idEquipamento = fnDecrypt($_REQUEST['equipamentoID']);
            $equipamentoDAO = new equipamentoDAO();
            $this->visao->equipamentoEditavel = $equipamentoDAO->equipamentoPodeTerTipoAlterado($idEquipamento);
            $this->visao->equipamentoID = $_REQUEST['equipamentoID'];
            $equipamento = $equipamentoDAO->recuperarEquipamento($idEquipamento);

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
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemover() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRetorno() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->saidas = (new equipamentoDAO())->consultarSaidas("idSaida, nomeEquipamento, numeroPatrimonio, concat(PNome,' ',UNome) AS `responsavel`,destino,nomePolo,quantidadeSaida,dataSaida");
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
            if ($value[4] == null){
                $value[4] = '';
            }
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovoretorno() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'saidaID') || filter_has_var(INPUT_POST, 'saidaID')) {
            $idSaida = fnDecrypt($_REQUEST['saidaID']);
            $equipamentoDAO = new equipamentoDAO();
            $saida = $equipamentoDAO->recuperarSaidaEquipamento($idSaida);

            $equipamentoID = $saida['equipamento'];
            $equipamento = $equipamentoDAO->recuperarEquipamento($equipamentoID);

            $this->visao->saidaID = fnEncrypt($idSaida);
            $this->visao->equipamentoID = fnEncrypt($equipamentoID);
            $this->visao->equipamento = $equipamento;
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->dataSaida = $saida['dataSaida'];
            $this->renderizar();
        } else {
            die("Acesso indevido");
        }
    }

    public function acaoRegistrarretorno() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoSaida() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->equipamentos = (new equipamentoDAO())->consultar("idEquipamento,nomeEquipamento,quantidade,dataEntrada,numeroPatrimonio", "quantidade > 0");
        $i = 0;
        foreach ($this->visao->equipamentos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->equipamentos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoNovasaida() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        if (filter_has_var(INPUT_GET, 'equipamentoID')) {
            $this->visao->comboboxPapeis = ComboBoxPapeis::montarTodosPapeis();
            $this->visao->equipamento = (new equipamentoDAO())->recuperarEquipamento(fnDecrypt(filter_input(INPUT_GET, 'equipamentoID')));
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->responsavel = ComboBoxUsuarios::listarTodosUsuarios();
            $this->visao->polos = ComboBoxPolo::montarTodosOsPolos();
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarsaida() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoListarusuarios() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoNovabaixa() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        if (filter_has_var(INPUT_GET, 'equipamentoID')) {
            $equipamento = (new equipamentoDAO())->recuperarEquipamento(fnDecrypt(filter_input(INPUT_GET, 'equipamentoID')));
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
            $equipamentoDAO = new equipamentoDAO();
            $saida = $equipamentoDAO->recuperarSaidaEquipamento(fnDecrypt(filter_input(INPUT_GET, 'saidaID')));
            $this->visao->dataMinima = $saida['dataSaida'];
            $this->visao->equipamento = $equipamentoDAO->recuperarEquipamento($saida['equipamento']);
            $this->visao->equipamentoID = fnEncrypt($this->visao->equipamento->get_idEquipamento());
            $this->visao->quantidadeMaxima = $saida['quantidadeSaida'];
            $this->visao->saidaID = filter_input(INPUT_GET, 'saidaID');
            $this->renderizar();
        } else {
            die("Acesso indevido.");
        }
    }

    public function acaoRegistrarbaixa() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoGerenciarbaixasesaidas() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_baixas() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->visao->baixas = (new equipamentoDAO())->consultarBaixas("idBaixa,nomeEquipamento,dataBaixa,quantidadeBaixa,saida,observacoes");
        $i = 0;
        foreach ($this->visao->baixas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->baixas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_baixa() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function acaoGerenciar_saidas() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->visao->saidas = (new equipamentoDAO())->consultarSaidas("idSaida,nomeEquipamento,dataSaida,quantidadeSaidaOriginal,concat(PNome,' ',UNome) as `responsavel`");
        $i = 0;
        foreach ($this->visao->saidas as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->saidas[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoRemover_saida() {
        $this->visao->acessoMinimo = Permissao::ADMINISTRADOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_EQUIPAMENTOS;
    }

}

?>
