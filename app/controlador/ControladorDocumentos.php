<?php

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
require_once APP_LIBRARY_DIR . "seguranca/Permissao.php";
require_once APP_LIBRARY_DIR . "seguranca/criptografia.php";
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
    
    public function acaoVerificarnovocabecalho(){
        $this->renderizar();
    }

    public function acaoVerificarnovocabecalho() {
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
    
    public function acaoGerenciarCabecalho(){
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
        
    }

    public function acaoGerenciarCabecalho() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoConsultar() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->oficios = listarOficios('validos');
        $this->visao->memorandos = listarMemorandos('validos');
        $this->renderizar();
    }

    public function acaoOficio() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->visao->tratamento = '';
        $this->visao->destino = '';
        $this->visao->cargo_destino = '';
        $this->visao->referencia = '';
        $this->visao->assunto = '';
        $this->visao->corpo = '';
        $this->visao->remetente = '';
        $this->visao->cargo_remetente = '';
        $this->visao->sigla = 'TEC';
        $this->visao->idoficio = fnEncrypt(-1);
        
        if (!isset($_GET['id'])) {
            $this->visao->action = 'gerar';
        } else {
            $ofc = (new documentoDAO())->consultar('documento_oficio', 'idOficio = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));
            $oficioTmp = $ofc[0];

            $this->visao->tratamento = $oficioTmp->get_tratamento();
            $this->visao->destino = $oficioTmp->get_destino();
            $this->visao->cargo_destino = $oficioTmp->get_cargo_destino();
            $this->visao->referencia = $oficioTmp->get_referencia();
            $this->visao->assunto = $oficioTmp->get_assunto();
            $this->visao->corpo = $oficioTmp->get_corpo();
            $this->visao->remetente = $oficioTmp->get_remetente();
            $this->visao->cargo_remetente = $oficioTmp->get_cargo_remetente();
            $this->visao->sigla = $oficioTmp->get_tipoSigla();
            if ($oficioTmp->get_numOficio() != -1) {
                $this->visao->action = 'aproveitar';
            } else {
                $this->visao->idoficio = fnEncrypt($oficioTmp->get_idOficio());
                $this->visao->action = 'editar';
            }
        }
        $this->renderizar();
    }

    public function acaoAproveitarOficio() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $ofc = (new documentoDAO())->consultar('documento_oficio', 'idOficio = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $oficioTmp = $ofc[0];

        $this->visao->tratamento = $oficioTmp->get_tratamento();
        $this->visao->destino = $oficioTmp->get_destino();
        $this->visao->cargo_destino = $oficioTmp->get_cargo_destino();
        $this->visao->referencia = $oficioTmp->get_referencia();
        $this->visao->assunto = $oficioTmp->get_assunto();
        $this->visao->corpo = $oficioTmp->get_corpo();
        $this->visao->remetente = $oficioTmp->get_remetente();
        $this->visao->cargo_remetente = $oficioTmp->get_cargo_remetente();
        $this->visao->sigla = $oficioTmp->get_tipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();



        $this->renderizar();
    }

    public function acaoEditarOficio() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $ofc = (new documentoDAO())->consultar('documento_oficio', 'idOficio = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $oficioTmp = $ofc[0];

        $this->visao->idoficio = $oficioTmp->get_idOficio();
        $this->visao->tratamento = $oficioTmp->get_tratamento();
        $this->visao->destino = $oficioTmp->get_destino();
        $this->visao->cargo_destino = $oficioTmp->get_cargo_destino();
        $this->visao->referencia = $oficioTmp->get_referencia();
        $this->visao->assunto = $oficioTmp->get_assunto();
        $this->visao->corpo = $oficioTmp->get_corpo();
        $this->visao->remetente = $oficioTmp->get_remetente();
        $this->visao->cargo_remetente = $oficioTmp->get_cargo_remetente();
        $this->visao->sigla = $oficioTmp->get_tipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoGerarRelatorio() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoMemorando() {
        
          $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->visao->tratamento = '';
        $this->visao->destino = '';
        $this->visao->cargo_destino = '';
        $this->visao->referencia = '';
        $this->visao->assunto = '';
        $this->visao->corpo = '';
        $this->visao->remetente = '';
        $this->visao->cargo_remetente = '';
        $this->visao->sigla = 'TEC';
        $this->visao->idmemorando = fnEncrypt(-1);
        
        if (!isset($_GET['id'])) {
            $this->visao->action = 'gerar';
        } else {
            $ofc = (new documentoDAO())->consultar('documento_memorando', 'idMemorando = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));
            $oficioTmp = $ofc[0];

            $this->visao->tratamento = $oficioTmp->get_tratamento();
            $this->visao->cargo_destino = $oficioTmp->get_cargo_destino();
            $this->visao->referencia = $oficioTmp->get_referencia();
            $this->visao->assunto = $oficioTmp->get_assunto();
            $this->visao->corpo = $oficioTmp->get_corpo();
            $this->visao->remetente = $oficioTmp->get_remetente();
            $this->visao->cargo_remetente = $oficioTmp->get_cargo_remetente();
            $this->visao->sigla = $oficioTmp->get_tipoSigla();
            if ($oficioTmp->get_numMemorando() != -1) {
                $this->visao->action = 'aproveitar';
            } else {
                $this->visao->idmemorando = fnEncrypt($oficioTmp->get_idMemorando());
                $this->visao->action = 'editar';
            }
        }
        $this->renderizar();
        
        
       
    }

    public function acaoEditarMemorando() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $mem = (new documentoDAO())->consultar('documento_memorando', 'idMemorando = ' . fnDecrypt(filter_input(INPUT_GET, 'id')));

        $memorandoTmp = $mem[0];

        $this->visao->idmemorando = $memorandoTmp->get_idMemorando();
        $this->visao->tratamento = $memorandoTmp->get_tratamento();
        $this->visao->cargo_destino = $memorandoTmp->get_cargo_destino();
        $this->visao->assunto = $memorandoTmp->get_assunto();
        $this->visao->corpo = $memorandoTmp->get_corpo();
        $this->visao->remetente = $memorandoTmp->get_remetente();
        $this->visao->cargo_remetente = $memorandoTmp->get_cargo_remetente();
        $this->visao->sigla = $memorandoTmp->get_tipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function acaoAproveitarMemorando() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $mem = (new documentoDAO())->consultar('documento_memorando', 'idMemorando = ' . fnDecrypt($_GET['id']));

        $memorandoTmp = $mem[0];

        $this->visao->tratamento = $memorandoTmp->get_tratamento();
        $this->visao->cargo_destino = $memorandoTmp->get_cargo_destino();
        $this->visao->assunto = $memorandoTmp->get_assunto();
        $this->visao->corpo = $memorandoTmp->get_corpo();
        $this->visao->remetente = $memorandoTmp->get_remetente();
        $this->visao->cargo_remetente = $memorandoTmp->get_cargo_remetente();
//        $this->visao->remetente2 = $memorandoTmp->getRemetente2();
//        $this->visao->cargo_remetente2 = $memorandoTmp->get_cargo_remetente2();
        $this->visao->sigla = $memorandoTmp->get_tipoSigla();

        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();

        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_DOCUMENTOS;
    }

}

?>
