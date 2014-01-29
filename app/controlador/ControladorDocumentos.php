<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once APP_LOCATION . 'modelo/dao/documentoDAO.php';
include_once APP_LOCATION . 'modelo/ComboBoxDocumentos.php';
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once APP_LOCATION.'modelo/documentos/listarDocumentos.php';

class ControladorDocumentos extends Controlador {
    
    public function acaoSalvar() {

        $this->renderizar();
    }
    
    public function acaoVerificarnovooficio(){
        $this->renderizar();
    }
    
    public function acaoVisualizarOficio(){
        $this->renderizar();
    }
    
    public function acaoVerificarnovomemorando(){
        $this->renderizar();
    }
    
    public function acaoVerificaratualizacaooficio(){
        $this->renderizar();
    }
    
//    public function acaoVerificaredicaooficio(){
//        $this->renderizar();
//    }
   
    public function acaoVerificaratualizacaomemorando(){
        $this->renderizar();
    }
    
    public function acaoDeletaroficio(){
        $this->renderizar();
    }
    
    public function acaoInvalidaroficio(){
        $this->renderizar();
    }
    
    public function acaoInvalidarmemorando(){
        $this->renderizar();
    }
    
    public function acaoDeletarmemorando(){
        $this->renderizar();
    }
    
    public function acaoGerenciar() {
        $this->visao->todosOficios = listarOficios();
        $this->visao->oficiosValidos = listarOficios('validos');
        $this->visao->oficiosInvalidos= listarOficios('invalidos');
        $this->visao->oficiosEmAberto= listarOficios('emAberto');
        $this->visao->todosMemorandos = listarMemorandos();
        $this->visao->memorandosValidos = listarMemorandos('validos');
        $this->visao->memorandosInvalidos = listarMemorandos('invalidos');
        $this->visao->memorandosEmAberto = listarMemorandos('emAberto');
        $this->renderizar();
    }
    
    public function acaoConsultar(){
        $this->visao->oficios = listarOficios('validos');
        $this->visao->memorandos = listarMemorandos('validos');
        $this->renderizar();
    }

    public function acaoGeraroficio() {
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        $this->renderizar();
    }

    public function acaoAproveitarOficio(){
        $ofc = documentoDAO::consultar('oficio', 'idOficio = ' . fnDecrypt($_GET['id']));
        
        $temp = $ofc[0];
        
        $this->visao->tratamento = $temp->getTratamento();
        $this->visao->destino = $temp->getDestino();
        $this->visao->cargo_destino = $temp->getCargo_destino();
        $this->visao->referencia = $temp->getReferencia();
        $this->visao->assunto = $temp->getAssunto();
        $this->visao->corpo = $temp->getCorpo();
        $this->visao->remetente = $temp->getRemetente();
        $this->visao->cargo_remetente = $temp->getCargo_remetente();
        $this->visao->remetente2 = $temp->getRemetente2();
        $this->visao->cargo_remetente2 = $temp->getCargo_remetente2();
        $this->visao->sigla = $temp->getTipoSigla();
        
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->renderizar();
    }
    
    public function acaoEditarOficio(){
        $ofc = documentoDAO::consultar('oficio', 'idOficio = ' . fnDecrypt($_GET['id']));
        
        $temp = $ofc[0];
        
        $this->visao->idoficio = $temp->getIdOficio();
        $this->visao->tratamento = $temp->getTratamento();
        $this->visao->destino = $temp->getDestino();
        $this->visao->cargo_destino = $temp->getCargo_destino();
        $this->visao->referencia = $temp->getReferencia();
        $this->visao->assunto = $temp->getAssunto();
        $this->visao->corpo = $temp->getCorpo();
        $this->visao->remetente = $temp->getRemetente();
        $this->visao->cargo_remetente = $temp->getCargo_remetente();
        $this->visao->remetente2 = $temp->getRemetente2();
        $this->visao->cargo_remetente2 = $temp->getCargo_remetente2();
        $this->visao->sigla = $temp->getTipoSigla();
        
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->renderizar();
    }
    
    public function acaoGerarRelatorio() {
        $this->renderizar();
    }

    public function acaoGerarMemorando() {
        
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->renderizar();
    }
    
    public function acaoEditarMemorando(){
        $mem = documentoDAO::consultar('memorando', 'idMemorando = ' . fnDecrypt($_GET['id']));
        
        $temp = $mem[0];
        
        $this->visao->idmemorando = $temp->getIdMemorando();
        $this->visao->tratamento = $temp->getTratamento();
        $this->visao->cargo_destino = $temp->getCargo_destino();
        $this->visao->assunto = $temp->getAssunto();
        $this->visao->corpo = $temp->getCorpo();
        $this->visao->remetente = $temp->getRemetente();
        $this->visao->cargo_remetente = $temp->getCargo_remetente();
        $this->visao->remetente2 = $temp->getRemetente2();
        $this->visao->cargo_remetente2 = $temp->getCargo_remetente2();
        $this->visao->sigla = $temp->getTipoSigla();
        
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->renderizar();
    }
    
    public function acaoAproveitarMemorando(){
        $mem = documentoDAO::consultar('memorando', 'idMemorando = ' . fnDecrypt($_GET['id']));
        
        $temp = $mem[0];
        
        $this->visao->tratamento = $temp->getTratamento();
        $this->visao->cargo_destino = $temp->getCargo_destino();
        $this->visao->assunto = $temp->getAssunto();
        $this->visao->corpo = $temp->getCorpo();
        $this->visao->remetente = $temp->getRemetente();
        $this->visao->cargo_remetente = $temp->getCargo_remetente();
        $this->visao->remetente2 = $temp->getRemetente2();
        $this->visao->cargo_remetente2 = $temp->getCargo_remetente2();
        $this->visao->sigla = $temp->getTipoSigla();
                
        $this->visao->comboDia = ComboBoxDocumentos::comboDia();
        $this->visao->comboMes = ComboBoxDocumentos::comboMes();
        
        $this->renderizar();
    }

}

?>
