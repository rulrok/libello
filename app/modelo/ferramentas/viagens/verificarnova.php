<?php

include_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Viagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

class verificarnovaviagem extends verificadorFormularioAjax {

    public function _validar() {
                $rodrigo;
        $curso = fnDecrypt(filter_input(INPUT_POST, 'curso'));
        if (!filter_has_var(INPUT_POST, 'destinoManual')) {
            $polo = fnDecrypt(filter_input(INPUT_POST, 'polo'));
            $destinoAlternativo = null;
        } else {
            $polo = null;
            $destinoAlternativo = filter_input(INPUT_POST, 'destinoManual');
        }
        $responsavel = fnDecrypt(filter_input(INPUT_POST, 'responsavel'));
        $dataIda = filter_input(INPUT_POST, 'start');
        $horaIda = filter_input(INPUT_POST, 'horaIda');
        $dataVolta = filter_input(INPUT_POST, 'end');
        $horaVolta = filter_input(INPUT_POST, 'horaVolta');
        $motivo = filter_input(INPUT_POST, 'motivo');
        $estado = filter_input(INPUT_POST, 'estado');
        $diarias = filter_input(INPUT_POST, 'diarias');
        $passageiros = filter_input(INPUT_POST, 'passageiros', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        for ($i = 0; $i < sizeof($passageiros); $i++) {
            $passageiros[$i] = fnDecrypt($passageiros[$i]);
        }

        $viagem = new Viagem();

        try {
            if ($curso != "" && (($polo != null && $polo != "" && $destinoAlternativo === null) || ($polo === null && $destinoAlternativo !== "")) && $responsavel != "" && $dataIda != "" && $horaIda != "" && $dataVolta != "" && $horaVolta != "" && $motivo != "" && $estado != "" && $diarias != "" && sizeof($passageiros) > 0) {
                $viagem->set_idCurso($curso)->set_idPolo($polo)->set_responsavel($responsavel)->set_dataIda($dataIda)->set_horaIda($horaIda)->set_dataVolta($dataVolta)->set_horaVolta($horaVolta)->set_motivo($motivo)->set_estado($estado)->set_diarias($diarias)->set_passageiros($passageiros)->set_destinoAlternativo($destinoAlternativo);
                if ((new viagemDAO())->inserir($viagem)) {
                    $this->adicionarMensagemSucesso("Cadastro com sucesso");
                } else {
                    $this->adicionarMensagemErro("Problema ao cadastrar no banco de dados.");
                }
            } else {
                $this->adicionarMensagemAviso("Preencha todos os campos obrigatórios!");
            }
        } catch (Exception $e) {
            $this->adicionarMensagemErro("Erro");
            print_r($e);
        }
    }

}

//$verificar = new verificarnovaviagem();
//$verificar->executar();
?>
