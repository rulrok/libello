<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verificarnovomemorando
 *
 * @author Rodolfo
 */
include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Memorando.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovomemorando extends verificadorFormularioAjax {

    //essa classe sera responsavel por gerar um novo memorando ou salvar um novo quando o numMemorando = -1

    public function _validar() {
        try {

            $idusuario = $_SESSION['usuario']->get_id();
            $numMemorando = $_REQUEST['i_numMemorando'];
            $assunto = $_REQUEST['assunto'];
            $corpo = $_REQUEST['corpo'];
            $dia = $_REQUEST['dia'];
            $mes = $_REQUEST['mes'];
            $ano = date('Y');
            $data = $dia . '/' . $mes . '/' . $ano;
            $tipoSigla = $_REQUEST['sigla'];
            $remetente = $_REQUEST['remetente'];
            $cargo_remetente = $_REQUEST['cargo_remetente'];

            $remetente2 = '';
            $cargo_remetente2 = '';
            $i_remetente = $_REQUEST['i_remetente'];


            if ($i_remetente == '1') {
                $remetente2 = $_REQUEST['remetente2'];
                $cargo_remetente2 = $_REQUEST['cargo_remetente2'];
            }


            $tratamento = $_REQUEST['tratamento'];
            $cargo_destino = $_REQUEST['cargo_destino'];

            $documento = new Memorando();
            $documento->setAssunto($assunto);
            $documento->setIdUsuario(trim($idusuario));
            $documento->setCorpo($corpo);
            $documento->setData($data);
            $documento->setTipoSigla($tipoSigla);
            $documento->setRemetente($remetente);
            $documento->setCargo_remetente($cargo_remetente);
            $documento->setRemetente2($remetente2);
            $documento->setCargo_remetente2($cargo_remetente2);
            $documento->setTratamento($tratamento);
            $documento->setCargo_destino($cargo_destino);

            $estadoEdicao = 0;
            if ($numMemorando == -1) {
                $estadoEdicao = 1;
            }

            $documento->setEstadoEdicao($estadoEdicao);
            $documento->setNumMemorando($numMemorando);

            $id = documentoDAO::inserirMemorando($documento);
            if ($numMemorando != -1) {

                $this->mensagem->set_mensagem("Memorando gerado com sucesso!")->set_status(Mensagem::SUCESSO);
            } else {
                $this->mensagem->set_mensagem("Memorando salvo com sucesso!")->set_status(Mensagem::SUCESSO);
            }
            $this->mensagem->id = fnEncrypt($id);
        } catch (Exception $e) {
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
    }

}

$verificar = new verificarnovomemorando();
$verificar->verificar();
?>


