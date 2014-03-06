<?php

include_once BIBLIOTECA_DIR . 'Mvc/Controlador.php';
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
include_once APP_DIR . 'modelo/dao/documentoDAO.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxDocumentos.php';
include_once APP_DIR . 'modelo/enumeracao/Ferramenta.php';
require_once APP_DIR . 'modelo/ferramentas/documentos/listarDocumentos.php';

class ControladorDocumentos extends Controlador {

    public function acaoSalvar() {
        $this->renderizar();
    }

    public function acaoVerificarnovooficio() {
        $this->renderizar();
    }

    public function acaoVisualizarOficio() {
        $this->renderizar();
    }

    public function acaoVisualizarMemorando() {
        $this->renderizar();
    }

    public function acaoVerificarnovomemorando() {
        $this->renderizar();
    }

    public function acaoVerificaratualizacaooficio() {
        $this->renderizar();
    }

    public function acaoCapturarNumDocumento() {
        $this->renderizar();
    }

//    public function acaoVerificaredicaooficio(){
//        $this->renderizar();
//    }

    public function acaoVerificaratualizacaomemorando() {
        $this->renderizar();
    }

    public function acaoDeletaroficio() {
        $this->renderizar();
    }

    public function acaoInvalidaroficio() {
        $this->renderizar();
    }

    public function acaoInvalidarmemorando() {
        $this->renderizar();
    }

    public function acaoDeletarmemorando() {
        $this->renderizar();
    }

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->todosOficios = listarOficios();
        $this->visao->oficiosValidos = listarOficios('validos');
        $this->visao->oficiosInvalidos = listarOficios('invalidos');
        $this->visao->oficiosEmAberto = listarOficios('emAberto');
        $this->visao->todosMemorandos = listarMemorandos();
        $this->visao->memorandosValidos = listarMemorandos('validos');
        $this->visao->memorandosInvalidos = listarMemorandos('invalidos');
        $this->visao->memorandosEmAberto = listarMemorandos('emAberto');
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->oficios = listarOficios('validos');
        $this->visao->memorandos = listarMemorandos('validos');
        $this->renderizar();
    }

    public function acaoGeraroficio() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        $this->renderizar();
    }

    public function acaoAproveitarOficio() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $ofc = (new documentoDAO())->consultar('oficio', 'idOficio = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $oficioTmp = $ofc[0];

        $this->visao->tratamento = $oficioTmp->getTratamento();
        $this->visao->destino = $oficioTmp->getDestino();
        $this->visao->cargo_destino = $oficioTmp->getCargo_destino();
        $this->visao->referencia = $oficioTmp->getReferencia();
        $this->visao->assunto = $oficioTmp->getAssunto();
        $this->visao->corpo = $oficioTmp->getCorpo();
        $this->visao->remetente = $oficioTmp->getRemetente();
        $this->visao->cargo_remetente = $oficioTmp->getCargo_remetente();
        $this->visao->remetente2 = $oficioTmp->getRemetente2();
        $this->visao->cargo_remetente2 = $oficioTmp->getCargo_remetente2();
        $this->visao->sigla = $oficioTmp->getTipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoEditarOficio() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $ofc = (new documentoDAO())->consultar('oficio', 'idOficio = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $oficioTmp = $ofc[0];

        $this->visao->idoficio = $oficioTmp->getIdOficio();
        $this->visao->tratamento = $oficioTmp->getTratamento();
        $this->visao->destino = $oficioTmp->getDestino();
        $this->visao->cargo_destino = $oficioTmp->getCargo_destino();
        $this->visao->referencia = $oficioTmp->getReferencia();
        $this->visao->assunto = $oficioTmp->getAssunto();
        $this->visao->corpo = $oficioTmp->getCorpo();
        $this->visao->remetente = $oficioTmp->getRemetente();
        $this->visao->cargo_remetente = $oficioTmp->getCargo_remetente();
        $this->visao->remetente2 = $oficioTmp->getRemetente2();
        $this->visao->cargo_remetente2 = $oficioTmp->getCargo_remetente2();
        $this->visao->sigla = $oficioTmp->getTipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoGerarRelatorio() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoGerarmemorando() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoEditarMemorando() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $mem = (new documentoDAO())->consultar('memorando', 'idMemorando = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $memorandoTmp = $mem[0];

        $this->visao->idmemorando = $memorandoTmp->getIdMemorando();
        $this->visao->tratamento = $memorandoTmp->getTratamento();
        $this->visao->cargo_destino = $memorandoTmp->getCargo_destino();
        $this->visao->assunto = $memorandoTmp->getAssunto();
        $this->visao->corpo = $memorandoTmp->getCorpo();
        $this->visao->remetente = $memorandoTmp->getRemetente();
        $this->visao->cargo_remetente = $memorandoTmp->getCargo_remetente();
        $this->visao->remetente2 = $memorandoTmp->getRemetente2();
        $this->visao->cargo_remetente2 = $memorandoTmp->getCargo_remetente2();
        $this->visao->sigla = $memorandoTmp->getTipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoAproveitarMemorando() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $mem = (new documentoDAO())->consultar('memorando', 'idMemorando = ' . fnDecrypt($_GET['id']));

        $memorandoTmp = $mem[0];

        $this->visao->tratamento = $memorandoTmp->getTratamento();
        $this->visao->cargo_destino = $memorandoTmp->getCargo_destino();
        $this->visao->assunto = $memorandoTmp->getAssunto();
        $this->visao->corpo = $memorandoTmp->getCorpo();
        $this->visao->remetente = $memorandoTmp->getRemetente();
        $this->visao->cargo_remetente = $memorandoTmp->getCargo_remetente();
        $this->visao->remetente2 = $memorandoTmp->getRemetente2();
        $this->visao->cargo_remetente2 = $memorandoTmp->getCargo_remetente2();
        $this->visao->sigla = $memorandoTmp->getTipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_DOCUMENTOS;
    }

}

?>
