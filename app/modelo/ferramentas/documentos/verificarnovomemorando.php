<?php

namespace app\modelo\ferramentas\documentos;

/**
 * Description of verificarnovomemorando
 *
 * @author Rodolfo
 */
require_once APP_DIR . "modelo/vo/Memorando.php";
include APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificarnovomemorando extends Modelo\verificadorFormularioAjax {

    //essa classe sera responsavel por gerar um novo memorando ou salvar um novo quando o numMemorando = -1

    public function _validar() {
        try {

            $idusuario = obterUsuarioSessao()->get_idUsuario();
            $idMemorando = fnDecrypt(filter_input(INPUT_POST, 'i_idmemorando'));
//            $numMemorando = filter_input(INPUT_POST, 'i_numMemorando');
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

            $documento = new Modelo\Memorando();
            $documento->set_assunto($assunto);
            $documento->set_idUsuario(trim($idusuario));
            $documento->set_corpo($corpo);
            $documento->set_data($data);
            $documento->set_tipoSigla($tipoSigla);
            $documento->set_remetente($remetente);
            $documento->set_cargo_remetente($cargo_remetente);
            $documento->set_tratamento($tratamento);
            $documento->set_cargo_destino($cargo_destino);

            $estadoEdicao = 1;
//            if ($numMemorando == -1) {
//                $estadoEdicao = 1;
//            }
//            $documento->set_numMemorando($numMemorando);
            $documento->set_estadoEdicao($estadoEdicao);

            $documentoDAO = new Modelo\documentoDAO();
            if ($idMemorando != -1) {
                $documento->set_idMemorando($idMemorando);
                $verifica = $documentoDAO->update_memorando($documento);
//                $id = $idMemorando;
            } else {
                $verifica = $documentoDAO->inserirMemorando($documento);
//                $id = $documentoDAO->obterUltimoIdInserido();
            }

//            if ($numMemorando != -1) {
//                $this->setId(-1);
//                $this->mensagemSucesso("Memorando gerado com sucesso!");
//            } else {
//                $this->setId($id);
            if ($verifica) {
                $this->adicionarMensagemSucesso("Memorando salvo com sucesso!");
            } else {
                $this->adicionarMensagemErro("Erro ao salvar memorando!");
            }

//            }
        } catch (Exception $e) {
            $this->adicionarMensagemErro($e->getMessage());
        }
    }

}

?>


