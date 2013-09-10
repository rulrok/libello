<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/app/modelo/dao/documentoDAO.php';

class ControladorDocumentos extends Controlador {

    public function acaoHistorico() {
        $this->renderizar();
    }

    public function acaoGeraroficio() {
        $this->renderizar();
    }
    public function acaoGerarRelatorio() {
        $this->renderizar();
    }

    public function acaoGerarMemorando() {
        $this->renderizar();
    }

    //comboDia() e comboMes() sao relativos a GerarOficio e Gerar Memorando
    //combo dia
    function comboDia() {
        echo "<select id='dia' name='dia'>
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
        echo "<select id='mes' name='mes'>
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
        $dao = new documentoDAO();
        $dao->inserirOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }

    function salvarOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        $dao = new documentoDAO();
        $dao->inserirOficio($idusuario, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }

    function atualizarOficio($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio) {
        update_oficioSalvo($idoficio, $assunto, $corpo, $tratamento, $destino, $cargo_destino, $data, $estadoEdicao, $tipoSigla, $referencia, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $numOficio);
    }

    function retornaNumOficio() {
        //$busca = selectMaxNumOficio();
       // $dao = new documentoDAO();
        $busca = documentoDAO::consultar("oficio","idOficio = (SELECT idOficio FROM oficio WHERE numOficio = (SELECT max(numOficio) FROM oficio WHERE numOficio > (-1)))");
        if ($busca != null) {
            $numOficio = $busca[0];
            $num = ($numOficio->getNumOficio() +1);
        } else {
            //erro
            $num = 1;
        }
        return $num;
    }

    function retornaNumMemorando() {
        $busca = documentoDAO::consultar("memorando","idMemorando = (SELECT idMemorando FROM memorando WHERE numMemorando = (SELECT max(numMemorando) FROM memorando WHERE numMemorando > (-1)))");
        if ($busca != null) {
            $numMem = $busca[0];
            $num = ($numMem->getNumMemorando() +1);
        } else {
            //erro
            $num = 1;
        }
        return $num;
    }

    function salvarMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        $dao = new documentoDAO();
        $dao->inserirMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }

    function novoMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        $dao = new documentoDAO();
        $retorno = $dao->inserirMemorando($idusuario, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    
        return $retorno;
    }

    function invalidarMemorando($idmemorando) {
        update_invalidarMemorando($idmemorando);
    }

    function deletarMemorando($idmemorando) {
        deleteMemorando($idmemorando);
    }

    function atualizarMemorando($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao) {
        update_memorandoSalvo($idmemorando, $numMemorando, $tipoSigla, $data, $tratamento, $cargo_destino, $assunto, $corpo, $remetente, $cargo_remetente, $remetente2, $cargo_remetente2, $estadoEdicao);
    }

}

?>
