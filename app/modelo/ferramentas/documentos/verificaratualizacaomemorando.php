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
include APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Memorando.php";
include APP_DIR . "visao/verificadorFormularioAjax.php";

class verificaratualizacaomemorando extends verificadorFormularioAjax {

    //essa classe sera responsavel por gerar um novo memorando ou salvar um novo quando o numMemorando = -1

    public function _validar() {
        try {

            $idusuario = $_SESSION['usuario']->get_idUsuario();
            $numMemorando = filter_input(INPUT_POST,'i_numMemorando');
            $idMemorando = filter_input(INPUT_POST,'i_idmemorando');
            $assunto = filter_input(INPUT_POST,'assunto');
            $corpo = filter_input(INPUT_POST,'corpo');
            $dia = filter_input(INPUT_POST,'dia');
            $mes = filter_input(INPUT_POST,'mes');
            $ano = date('Y');
            $data = $dia . '/' . $mes . '/' . $ano;
            $tipoSigla = filter_input(INPUT_POST,'sigla');
            $remetente = filter_input(INPUT_POST,'remetente');
            $cargo_remetente = filter_input(INPUT_POST,'cargo_remetente');

            $remetente2 = '';
            $cargo_remetente2 = '';
            $i_remetente = filter_input(INPUT_POST,'i_remetente');


            if ($i_remetente == '1') {
                $remetente2 = filter_input(INPUT_POST,'remetente2');
                $cargo_remetente2 = filter_input(INPUT_POST,'cargo_remetente2');
            }


            $tratamento = filter_input(INPUT_POST,'tratamento');
            $cargo_destino = filter_input(INPUT_POST,'cargo_destino');

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
            $documento->setIdMemorando($idMemorando);

            $estadoEdicao = 0;
            if ($numMemorando == -1) {
                $estadoEdicao = 1;
            }

            $documento->setEstadoEdicao($estadoEdicao);
            $documento->setNumMemorando($numMemorando);

            (new documentoDAO())->update_memorando($documento);
            if ($numMemorando != -1) {

                $this->mensagem->set_mensagemSucesso("Memorando gerado com sucesso!");
            } else {
                $this->mensagem->set_mensagemErro("Memorando salvo com sucesso!");
            }
//            $this->mensagem->id = fnEncrypt($idMemorando);
        } catch (Exception $e) {
            $this->mensagem->set_mensagemErro($e->getMessage());
        }
    }

}

$verificar = new verificaratualizacaomemorando();
$verificar->verificar();
?>
