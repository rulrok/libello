<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $equipamentoID = fnDecrypt($_POST['equipamentoID']);
            $dataSaida = $_POST['dataSaida'];
            if (!isset($_POST['destinoManual'])) {
                $destino = fnDecrypt($_POST['polo']);
                $destinoAlternativo = "NULL";
            } else {
                $destino = "NULL";
                $destinoAlternativo = $_POST['destinoManual'];
            }
            $quantidade = (int) $_POST['quantidade'];
            $responsavel = fnDecrypt($_POST['responsavel']);


            if ($equipamentoID >= 0 && $dataSaida !== "" && (($destino != "NULL" && $destino != "" && $destinoAlternativo === "NULL") || ($destino === "NULL" && $destinoAlternativo !== "")) && $quantidade > 0 && $responsavel >= 0) {
                if (equipamentoDAO::cadastrarSaida($equipamentoID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
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