<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $equipamentoID = $_POST['equipamentoID'];
            $dataSaida = $_POST['dataSaida'];
            $destino = $_POST['destino'];
            $quantidade = (int) $_POST['quantidade'];
            $responsavel = $_POST['responsavel'];


            if ($equipamentoID >= 0 && $dataSaida !== "" && $destino !== "" && $quantidade > 0 && $responsavel >= 0) {
                if (equipamentoDAO::cadastrarSaida($equipamentoID, $equipamentoID, $destino, $quantidade, $dataSaida)) {
                    $this->mensagem->set_mensagem("Saída registrada");
                    $this->mensagem->set_status(Mensagem::SUCESSO);
                } else {
                    $this->mensagem->set_mensagem("Erro ao cadastrar no banco");
                $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Dados inválidos");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$registrarSaida = new registrarSaida();
$registrarSaida->verificar();
?>