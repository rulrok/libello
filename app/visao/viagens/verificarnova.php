<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Viagem.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnova extends verificadorFormularioAjax {

    public function _validar() {
        $curso = fnDecrypt($_POST['curso']);
        if (!isset($_POST['destinoManual'])) {
            $polo = fnDecrypt($_POST['polo']);
            $destinoAlternativo = "NULL";
        } else {
            $polo = "NULL";
            $destinoAlternativo = $_POST['destinoManual'];
        }
        $responsavel = fnDecrypt($_POST['responsavel']);
        $dataIda = $_POST['dataIda'];
        $horaIda = $_POST['horaIda'];
        $dataVolta = $_POST['dataVolta'];
        $horaVolta = $_POST['horaVolta'];
        $motivo = $_POST['motivo'];
        $estado = $_POST['estado'];
        $diarias = $_POST['diarias'];
        $passageiros = $_POST['passageiros'];
        for ($i = 0; $i < sizeof($passageiros); $i++) {
            $passageiros[$i] = fnDecrypt($passageiros[$i]);
        }

        $viagem = new Viagem();

        try {
            if ($curso != "" && (($polo != "NULL" && $polo != "" && $destinoAlternativo === "NULL") || ($polo === "NULL" && $destinoAlternativo !== "")) && $responsavel != "" && $dataIda != "" && $horaIda != "" && $dataVolta != "" && $horaVolta != "" && $motivo != "" && $estado != "" && $diarias != "" && sizeof($passageiros) > 0) {
                $viagem->set_idCurso($curso)->set_idPolo($polo)->set_responsavel($responsavel)->set_dataIda($dataIda)->set_horaIda($horaIda)->set_dataVolta($dataVolta)->set_horaVolta($horaVolta)->set_motivo($motivo)->set_estado($estado)->set_diarias($diarias)->set_passageiros($passageiros)->set_destinoAlternativo($destinoAlternativo);
                if (viagemDAO::inserir($viagem)) {
                    $this->mensagem->set_mensagem("Cadastro com sucesso")->set_status(Mensagem::SUCESSO);
                } else {
                    $this->mensagem->set_mensagem("Problema ao cadastrar no banco de dados.")->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Preencha todos os campos obrigatórios!")->set_status(Mensagem::INFO);
            }
        } catch (Exception $e) {
            $this->mensagem->set_mensagem("Erro")->set_status(Mensagem::ERRO);
            print_r($e);
        }
    }

}

$verificar = new verificarnova();
$verificar->verificar();
?>
