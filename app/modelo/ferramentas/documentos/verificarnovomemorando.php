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
require_once APP_DIR . "modelo/vo/Memorando.php";
include APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarnovomemorando extends verificadorFormularioAjax {

    //essa classe sera responsavel por gerar um novo memorando ou salvar um novo quando o numMemorando = -1

    public function _validar() {
        try {

            $idusuario = obterUsuarioSessao()->get_idUsuario();
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




            $tratamento = filter_input(INPUT_POST, 'tratamento');
            $cargo_destino = filter_input(INPUT_POST, 'cargo_destino');

            $documento = new Memorando();
            $documento->set_assunto($assunto);
            $documento->set_idUsuario(trim($idusuario));
            $documento->set_corpo($corpo);
            $documento->set_data($data);
            $documento->set_tipoSigla($tipoSigla);
            $documento->set_remetente($remetente);
            $documento->set_cargo_remetente($cargo_remetente);
            $documento->set_tratamento($tratamento);
            $documento->set_cargo_destino($cargo_destino);

            $estadoEdicao = 0;
            if ($numMemorando == -1) {
                $estadoEdicao = 1;
            }

            $documento->set_estadoEdicao($estadoEdicao);
            $documento->set_numMemorando($numMemorando);

            $documentoDAO = new documentoDAO();
            $documentoDAO->inserirMemorando($documento);
            if ($numMemorando != -1) {
                $id = $documentoDAO->obterUltimoIdInserido();
                $this->setId($id);
                $this->mensagemSucesso("Memorando gerado com sucesso!");
            } else {
                $this->mensagemSucesso("Memorando salvo com sucesso!");
            }
        } catch (Exception $e) {
            $this->mensagemErro($e->getMessage());
        }
    }

}

$verificar = new verificarnovomemorando();
$verificar->verificar();
?>


