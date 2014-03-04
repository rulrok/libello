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

            $idusuario = $_SESSION['usuario']->get_idUsuario();
            $numMemorando = filter_input(INPUT_POST, 'i_numMemorando');
            $assunto = filter_input(INPUT_POST, 'assunto');
            $corpo = filter_input(INPUT_POST, 'corpo');
            $dia = filter_input(INPUT_POST, 'dia');
            $mes = filter_input(INPUT_POST, 'mes');
            $ano = date('Y');
            $data = $dia . '/' . $mes . '/' . $ano;
            $tipoSigla = filter_input(INPUT_POST, 'sigla');
            $remetente = filter_input(INPUT_POST, 'remetente');
            $cargo_remetente = filter_input(INPUT_POST, 'cargo_remetente');

            $remetente2 = '';
            $cargo_remetente2 = '';
            $i_remetente = filter_input(INPUT_POST, 'i_remetente');


            if ($i_remetente == '1') {
                $remetente2 = filter_input(INPUT_POST, 'remetente2');
                $cargo_remetente2 = filter_input(INPUT_POST, 'cargo_remetente2');
            }


            $tratamento = filter_input(INPUT_POST, 'tratamento');
            $cargo_destino = filter_input(INPUT_POST, 'cargo_destino');

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

            $documentoDAO = new documentoDAO();
            $documentoDAO->inserirMemorando($documento);
//            $id = $documentoDAO->obterUltimoIdInserido();
            if ($numMemorando != -1) {
                $this->mensagemSucesso("Memorando gerado com sucesso!");
            } else {
                $this->mensagemSucesso("Memorando salvo com sucesso!");
            }
//            $this->mensagem->id = fnEncrypt($id);
        } catch (Exception $e) {
            $this->mensagemErro($e->getMessage());
        }
    }

}

$verificar = new verificarnovomemorando();
$verificar->verificar();
?>


