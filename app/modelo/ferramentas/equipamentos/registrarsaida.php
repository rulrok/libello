<?php

include_once APP_DIR . "modelo/Mensagem.php";
include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

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
            $this->adicionarMensagemErro("Data é um campo obrigatório");
        }
        if ($quantidade <= 0) {
            $this->adicionarMensagemErro("Quantidade inválida");
        }

        if (($destino == null || $destino == "" || $destinoAlternativo !== null) && ($destino !== null || $destinoAlternativo === "")) {
            $this->adicionarMensagemErro("Destino inválido");
        }
        $equipamentoDAO = new equipamentoDAO();
        if ($equipamentoDAO->cadastrarSaida($equipamentoID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
            $id = $equipamentoDAO->obterUltimoIdInserido();
            $equipamentoDAO->registrarCadastroSaida($id);
            $this->adicionarMensagemSucesso("Saída registrada");
        } else {
            $this->adicionarMensagemErro("Erro ao cadastrar no banco");
        }
    }

}

//$registrarSaida = new registrarSaida();
//$registrarSaida->executar();
?>