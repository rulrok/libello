<?php

require_once APP_DIR . "modelo/vo/Oficio.php";
include APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarnovooficio extends verificadorFormularioAjax {

    public function _validar() {
        try {
            $idusuario = obterUsuarioSessao()->get_idUsuario();
            $idOficio = fnDecrypt(filter_input(INPUT_POST, 'i_idoficio'));
            $numOficio = filter_input(INPUT_POST, 'i_numOficio');
            $assunto = filter_input(INPUT_POST, 'assunto');
            $corpo = filter_input(INPUT_POST, 'corpo');
            $destino = filter_input(INPUT_POST, 'destino');
            $referencia = filter_input(INPUT_POST, 'referencia');
            $dia = filter_input(INPUT_POST, 'dia');
            $mes = filter_input(INPUT_POST, 'mes');
            $ano = date('Y');
            $data = $dia . '/' . $mes . '/' . date('Y');
            $tipoSigla = filter_input(INPUT_POST, 'sigla');
            $remetente = filter_input(INPUT_POST, 'remetente');
            $cargo_remetente = filter_input(INPUT_POST, 'cargo_remetente');

            $tratamento = filter_input(INPUT_POST, 'tratamento');
            $cargo_destino = filter_input(INPUT_POST, 'cargo_destino');

            $documento = new Oficio();
            $documento->set_assunto($assunto);
            $documento->set_idUsuario(trim($idusuario));
            $documento->set_corpo($corpo);
            $documento->set_destino($destino);
            $documento->set_referencia($referencia);
            $documento->set_data($data);
            $documento->set_tipoSigla($tipoSigla);
            $documento->set_remetente($remetente);
            $documento->set_cargo_remetente($cargo_remetente);
            $documento->set_tratamento($tratamento);
            $documento->set_cargo_destino($cargo_destino);

            $estadoEdicao = 0;

            if ($numOficio == -1) {
                $estadoEdicao = 1;
            }
            $documento->set_estadoEdicao($estadoEdicao);
            $documento->set_numOficio($numOficio);
            $documentoDAO = new documentoDAO();
            if ($idOficio != -1) {
                $documento->set_idOficio($idOficio);
                $documentoDAO->update_oficio($documento);
                $id = $idOficio;
            } else {

                $problema = $documentoDAO->inserirOficio($documento);
                $id = $documentoDAO->obterUltimoIdInserido();
            }

                $this->setId($id);
            if ($numOficio != -1) {
                $this->setDocumento('gerar');
                $this->mensagemSucesso("Oficio gerado com sucesso!");
            } else {
                $this->mensagemSucesso("Oficio salvo com sucesso!");
            }
        } catch (Exception $e) {
            $this->mensagemErro($e->getMessage());
        }
    }

}

$verificar = new verificarnovooficio();
$verificar->verificar();
?>