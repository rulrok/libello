<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/app/modelo/dao/documentoDAO.php';
require_once APP_LOCATION."modelo/enumeracao/Ferramenta.php";
require_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
require_once BIBLIOTECA_DIR . "seguranca/Permissao.php";

class ControladorDocumentos extends Controlador {

    public function acaoGerenciar() {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $this->visao->todosOficios = $this->listarOficios();
        $this->visao->oficiosValidos = $this->listarOficios('validos');
        $this->visao->oficiosInvalidos= $this->listarOficios('invalidos');
        $this->visao->oficiosEmAberto= $this->listarOficios('emAberto');
        $this->visao->todosMemorandos = $this->listarMemorandos();
        $this->visao->memorandosValidos = $this->listarMemorandos('validos');
        $this->visao->memorandosInvalidos = $this->listarMemorandos('invalidos');
        $this->visao->memorandosEmAberto = $this->listarMemorandos('emAberto');
        $this->renderizar();
    }
    
    public function acaoConsultar(){
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->visao->oficios = $this->listarOficios('validos');
        $this->visao->memorandos = $this->listarMemorandos('validos');
        $this->renderizar();
    }

    public function acaoGeraroficio() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        $this->renderizar();
    }

    public function acaoAproveitarOficio(){
        $this->visao->acessoMinimo = Permissao::ESCRITA;
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
        
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        
        $this->renderizar();
    }
    
    public function acaoEditarOficio(){
        $this->visao->acessoMinimo = Permissao::GESTOR;
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
        
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        
        $this->renderizar();
    }
    
    public function acaoGerarRelatorio() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $this->renderizar();
    }

    public function acaoGerarMemorando() {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        
        $this->renderizar();
    }
    
    public function acaoEditarMemorando(){
        $this->visao->acessoMinimo = Permissao::GESTOR;
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
        
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        
        $this->renderizar();
    }
    
    public function acaoAproveitarMemorando(){
        $this->visao->acessoMinimo = Permissao::ESCRITA;
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
                
        $this->visao->comboDia = $this->comboDia();
        $this->visao->comboMes = $this->comboMes();
        
        $this->renderizar();
    }
    
    //comboDia() e comboMes() sao relativos a GerarOficio e Gerar Memorando
    //combo dia
    function comboDia() {
        return "<select id='dia' name='dia'>
                <option value='01'>01</option>
                <option value='02'>02</option>
                <option value='03'>03</option>
                <option value='04'>04</option>
                <option value='05'>05</option>
                <option value='06'>06</option>
                <option value='07'>07</option>
                <option value='08'>08</option>
                <option value='09'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
                <option value='13'>13</option>
                <option value='14'>14</option>
                <option value='15'>15</option>
                <option value='16'>16</option>
                <option value='17'>17</option>
                <option value='18'>18</option>
                <option value='19'>19</option>
                <option value='20'>20</option>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
                <option value='25'>25</option>
                <option value='26'>26</option>
                <option value='27'>27</option>
                <option value='28'>28</option>
                <option value='29'>29</option>
                <option value='30'>30</option>
                <option value='31'>31</option>
            </select>";
    }

    //combo mês
    function comboMes() {
        return "<select id='mes' name='mes'>
                <option value='01'>janeiro</option>
                <option value='02'>fevereiro</option>
                <option value='03'>março</option>
                <option value='04'>abril</option>
                <option value='05'>maio</option>
                <option value='06'>junho</option>
                <option value='07'>julho</option>
                <option value='08'>agosto</option>
                <option value='09'>setembro</option>
                <option value='10'>outubro</option>
                <option value='11'>novembro</option>
                <option value='12'>dezembro</option>
            </select>";
    }

    function menuGerenciar() {
        $menu = " <div class=\"btn-toolbar\">
                    <div class=\"btn-group\">
                        <button class=\"btn btn-adicionar\"><i class=\"icon-user\"></i> Adicionar novo</button>
                        <button class=\"btn btn-editar\" href=\"#\"><i class=\"icon-edit\"></i> Editar</button>
                        <button class=\"btn btn-danger btn-deletar\" href=\"#\"><i class=\"icon-remove\"></i> Excluir</button>
                    </div>
                </div>";

        return $menu;
    }

    function novoOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $dao = new documentoDAO();
        $dao->inserirOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }

    function salvarOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $dao = new documentoDAO();
        $dao->inserirOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }
    
    function deletarOficio($idoficio) {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $retorno = $dao->deleteOficio($idoficio);
        return $retorno;
    }

    function invalidarOficio($idoficio){
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $dao->update_invalidarOficio($idoficio);
    }
    
    function atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $dao->update_oficioSalvo($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }

    function retornaNumOficio() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        //$busca = selectMaxNumOficio();
        // $dao = new documentoDAO();
        $busca = documentoDAO::consultar("oficio", "idOficio = (SELECT idOficio FROM oficio WHERE numOficio = (SELECT max(numOficio) FROM oficio WHERE numOficio > (-1)))");
        if ($busca != null) {
            $numOficio = $busca[0];
            $num = ($numOficio->getNumOficio() + 1);
        } else {
            $num = 1;
        }
        return $num;
    }

    function retornaNumMemorando() {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $busca = documentoDAO::consultar("memorando", "idMemorando = (SELECT idMemorando FROM memorando WHERE numMemorando = (SELECT max(numMemorando) FROM memorando WHERE numMemorando > (-1)))");
        if ($busca != null) {
            $numMem = $busca[0];
            $num = ($numMem->getNumMemorando() + 1);
        } else {
            //erro
            $num = 1;
        }
        return $num;
    }

    function salvarMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $dao = new documentoDAO();
        $dao->inserirMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }

    function novoMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        $this->visao->acessoMinimo = Permissao::ESCRITA;
        $dao = new documentoDAO();
        $retorno = $dao->inserirMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);

        return $retorno;
    }

    function invalidarMemorando($idmemorando) {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $dao->update_invalidarMemorando($idmemorando);
    }

    function deletarMemorando($idmemorando) {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $retorno = $dao->deleteMemorando($idmemorando);
        return $retorno;
    }

    function atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        $this->visao->acessoMinimo = Permissao::GESTOR;
        $dao = new documentoDAO();
        $dao->update_memorandoSalvo($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }

    function listarOficios($tipo = 'todos') {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $oficios = documentoDAO::consultar();
        $num_linhas = count($oficios);
        $retorno = '';
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if (($oficios[$i]->getEstadoEdicao() == 0) && $tipo != 'emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->getEstadoValidacao() == 0 && $tipo != 'validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                   // $retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    $retorno.="</tr>";
                    //se eh valido
                } else if ($oficios[$i]->getEstadoValidacao() != 0 && $tipo != 'invalidos') {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td width='30%' class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td width='30%' class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td width='10%' class='numeracao' align='center'>" . $oficios[$i]->getNumOficio() . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="</tr>";
                }
            } else if (($oficios[$i]->getEstadoEdicao() != 0) && ($tipo == 'emAberto' || $tipo == 'todos')) {
                if ($oficios[$i]->getIdUsuario() == $_SESSION['usuario']->get_id()) {
                    $retorno.="<tr tipo='".$tipo."' doc='oficio'>";
                    $retorno.="<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdOficio()) . '</td>';
                    //$retorno.="<td hidden class='campoID'>" . $oficios[$i]->getIdOficio() . '</td>';
                    $retorno.="<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.="<td  class='destino'>" . $oficios[$i]->getDestino() . "</td>";
                    $retorno.="<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.="<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.="<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.="</tr>";
                }
            }
        }
        return $retorno;
    }

    function listarMemorandos($tipo = 'todos') {
        $this->visao->acessoMinimo = Permissao::CONSULTA;
        $oficios = documentoDAO::consultar('memorando');
        $num_linhas = count($oficios);
        
        $retorno ='';
        
        for ($i = 0; $i < $num_linhas; $i++) {
            //se nao eh documento aproveitavel
            if ($oficios[$i]->getEstadoEdicao() == 0 && $tipo !='emAberto') {
                //se eh documento invalido
                if ($oficios[$i]->getEstadoValidacao() == 0 && $tipo !='validos') {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->getIdMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->getNumMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Inválido" . "</td>";
                    //se eh valido
                    $retorno.= '</tr>';
                } else if ($oficios[$i]->getEstadoValidacao() != 0 && $tipo !='invalidos'){
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . $oficios[$i]->getNumMemorando() . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= '</tr>';
                }
            } else if (($oficios[$i]->getEstadoEdicao() != 0) && ($tipo =='emAberto' || $tipo== 'todos')) {
                if ($oficios[$i]->getIdUsuario() == $_SESSION['usuario']->get_id()) {
                    $retorno.= "<tr tipo='".$tipo."' doc='memorando'>";
                    $retorno.= "<td hidden class='campoID'>" . fnEncrypt($oficios[$i]->getIdMemorando()) . '</td>';
                    //$retorno.= "<td hidden class='campoID'>" . $oficios[$i]->getIdMemorando() . '</td>';
                    $retorno.= "<td  class='assunto'>" . $oficios[$i]->getAssunto() . "</td>";
                    $retorno.= "<td  class='destino'>" . $oficios[$i]->getCargo_destino() . "</td>";
                    $retorno.= "<td  class='numeracao' align='center'>" . "Em aberto" . "</td>";
                    $retorno.= "<td  class='data' align='center'>" . $oficios[$i]->getData() . "</td>";
                    $retorno.= "<td  class='validacao' align='center'>" . "Válido" . "</td>";
                    $retorno.= '</tr>';
                }
            }
        }
        return $retorno;
    }

    public function idFerramentaAssociada() {
        return Ferramenta::CONTROLE_DOCUMENTOS;
    }

}

?>
