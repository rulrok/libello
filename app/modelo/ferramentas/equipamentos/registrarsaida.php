<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "visao/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        $equipamentoID = fnDecrypt(filter_input(INPUT_POST, 'equipamentoID'));
        $dataSaida = filter_input(INPUT_POST, 'dataSaida');
        if (!filter_has_var(INPUT_POST, 'destinoManual')) {
            $destino = fnDecrypt(filter_input(INPUT_POST, 'polo'));
            $destinoAlternativo = null;
        } else {
            $destino = null;
            $destinoAlternativo = filter_input(INPUT_POST, 'destinoManual');
        }
        $quantidade = (int) filter_input(INPUT_POST, 'quantidade');
        $responsavel = fnDecrypt(filter_input(INPUT_POST, 'responsavel'));

        if ($dataSaida == "") {
            $this->mensagemErro("Data é um campo obrigatório");
        }
        if ($quantidade <= 0) {
            $this->mensagemErro("Quantidade inválida");
        }

        if (($destino == null || $destino == "" || $destinoAlternativo !== null) && ($destino !== null || $destinoAlternativo === "")) {
            $this->mensagemErro("Destino inválido");
        }
        $equipamentoDAO = new equipamentoDAO();
        if ($equipamentoDAO->cadastrarSaida($equipamentoID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
            $id = $equipamentoDAO->obterUltimoIdInserido();
            $equipamentoDAO->registrarCadastroSaida($id);
            $this->mensagemSucesso("Saída registrada");
        } else {
            $this->mensagemErro("Erro ao cadastrar no banco");
        }
    }

}

$registrarSaida = new registrarSaida();
$registrarSaida->verificar();
?>