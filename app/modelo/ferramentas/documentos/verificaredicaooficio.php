<?php

include APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Oficio.php";
include APP_DIR . "visao/verificadorFormularioAjax.php";

class verificaredicaooficio extends verificadorFormularioAjax {

    public function _validar() {
        try {
            $idusuario = $_SESSION['usuario']->get_idUsuario();
            $idoficio = fnDecrypt(filter_input(INPUT_POST, 'i_idoficio'));
            $numOficio = filter_input(INPUT_POST, 'i_numOficio');
            $assunto = filter_input(INPUT_POST, 'assunto');
            $corpo = filter_input(INPUT_POST, 'corpo');
            $destino = filter_input(INPUT_POST, 'destino');
            $referencia = filter_input(INPUT_POST, 'referencia');
            $dia = filter_input(INPUT_POST, 'dia');
            $mes = filter_input(INPUT_POST, 'mes');
            $ano = date('Y');
            $data = $dia . '/' . $mes . '/' . $ano;
            $tipoSigla = filter_input(INPUT_POST, 'sigla');
            $remetente = filter_input(INPUT_POST, 'remetente');
            $cargo_remetente = filter_input(INPUT_POST, 'cargo_remetente');





            $tratamento = filter_input(INPUT_POST, 'tratamento');
            $cargo_destino = filter_input(INPUT_POST, 'cargo_destino');

            $documento = new Oficio();
            $documento->setIdOficio($idoficio);
            $documento->setAssunto($assunto);
            $documento->setIdUsuario(trim($idusuario));
            $documento->setCorpo($corpo);
            $documento->setDestino($destino);
            $documento->setReferencia($referencia);
            $documento->setData($data);
            $documento->setTipoSigla($tipoSigla);
            $documento->setRemetente($remetente);
            $documento->setCargo_remetente($cargo_remetente);
            $documento->setTratamento($tratamento);
            $documento->setCargo_destino($cargo_destino);

            $estadoEdicao = 0;

            if ($numOficio == -1) {
                $estadoEdicao = 1;
            }

            $documento->setEstadoEdicao($estadoEdicao);
            $documento->setNumOficio($numOficio);

            (new documentoDAO())->update_oficio($documento);
            if ($numOficio != -1) {
                $this->mensagemSucesso("Oficio gerado com sucesso!");
            } else {

                $this->mensagemSucesso("Oficio salvo com sucesso!");
            }
//            $this->mensagem->id = fnEncrypt($idoficio);
            //return fnEncrypt($id);
        } catch (Exception $e) {
            $this->mensagemErro($e->getMessage());
        }
    }

//put your code here
}

$verificar = new verificaredicaooficio();
$verificar->verificar();
?>
