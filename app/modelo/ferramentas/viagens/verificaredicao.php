<?php

namespace app\modelo\ferramentas\viagens;

require_once APP_DIR . "modelo/vo/Viagem.php";
require_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

//TODO Precisa ser revisado - incompleto
class verificaredicao extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $idViagem = fnDecrypt(filter_input(INPUT_POST, 'idViagem'));
        $idCurso = filter_input(INPUT_POST, 'idCurso', FILTER_VALIDATE_INT);
        $idPolo = filter_input(INPUT_POST, 'idPolo', FILTER_VALIDATE_INT);
        $responsavel = filter_input(INPUT_POST, 'responsavel');
        $dataIda = filter_input(INPUT_POST, 'dataIda');
        $horaIda = filter_input(INPUT_POST, 'horaIda');
        $dataVolta = filter_input(INPUT_POST, 'dataVolta');
        $horaVolta = filter_input(INPUT_POST, 'horaVolta');
        $motivo = filter_input(INPUT_POST, 'motivo');
        $estadoViagem = filter_input(INPUT_POST, 'estadoViagem');
        $diarias = filter_input(INPUT_POST, 'diarias');
        $outroDestino = filter_input(INPUT_POST, 'outroDestino');

        $ocorreu_erro = false;
        if ($idCurso == "") {
            $this->adicionarMensagemErro("A viagem deve ser relacionada a algum curso.");
            $ocorreu_erro = true;
        }
        if ($responsavel == "") {
            $this->adicionarMensagemErro("É obrigatório a escolha de um responsável.");
            $ocorreu_erro = true;
        }
        if ($dataIda == "") {
            $this->adicionarMensagemErro("É necessário determinar uma data de saída.");
            $ocorreu_erro = true;
        }
        if ($horaIda == "") {
            $this->adicionarMensagemErro("É necessário determinar o horário de saída.");
            $ocorreu_erro = true;
        }
        if ($dataVolta == "") {
            $this->adicionarMensagemErro("É necessário determinar a data de retorno.");
            $ocorreu_erro = true;
        }
        if ($horaVolta == "") {
            $this->adicionarMensagemErro("É necessário determinar a hora do retorno.");
            $ocorreu_erro = true;
        }
        if ($motivo == "") {
            $this->adicionarMensagemErro("Não foi definido a razão da viagem.");
            $ocorreu_erro = true;
        }
        if ($estadoViagem == "") {
            $this->adicionarMensagemErro("O estado da viagem não foi determinado.");
            $ocorreu_erro = true;
        }
        if ($diarias == "") {
            $this->adicionarMensagemErro("O número de diárias não foi definido.");
            $ocorreu_erro = true;
        }
        if ($idPolo === null && $outroDestino === null) {
            $this->adicionarMensagemErro("A viagem deve ter um destino definido.");
            $ocorreu_erro = true;
        }

        $viagemDAO = new viagemDAO();
        $viagem = $viagemDAO->recuperarViagem($idViagem);

        if ($diarias <= 0) {
            $this->adicionarMensagemErro("O número de diarias deve ser positivo.");
            $ocorreu_erro = true;
        }
        if ($outroDestino != "") {
            $viagem->set_outroDestino($outroDestino);
        } else {
            $viagem->set_idPolo($idPolo);
        }

        if ($ocorreu_erro) {
            $this->abortarExecucao();
        }
        $viagem->set_idCurso($idCurso)->set_responsavel($responsavel)->set_dataIda($dataIda)->set_horaIda($horaIda)->set_dataVolta($dataVolta)->set_horaVolta($horaVolta)->set_motivo($motivo)->set_estado($estadoViagem)->set_diarias($diarias);

        if ($viagemDAO->atualizar($idViagem, $viagem)) {
            $this->adicionarMensagemSucesso("Atualizado com sucesso");
        } else {
            $this->adicionarMensagemErro("Um erro ocorreu ao cadastrar no banco");
            $this->abortarExecucao();
        }
    }

}

?>