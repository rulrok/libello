<?php

include_once APP_LOCATION . "modelo/Mensagem.php";
include_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class registrarSaida extends verificadorFormularioAjax {

    public function _validar() {
        $livroID = fnDecrypt(filter_input(INPUT_POST, 'livroID'));
        $dataSaida = filter_input(INPUT_POST, 'dataSaida');
        if (!filter_has_var(INPUT_POST, 'destinoManual')) {
            $destino = fnDecrypt(filter_input(INPUT_POST, 'polo'));
            $destinoAlternativo = "NULL";
        } else {
            $destino = "NULL";
            $destinoAlternativo = filter_input(INPUT_POST, 'destinoManualF');
        }
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $responsavel = fnDecrypt(filter_input(INPUT_POST, 'responsavel'));


        if ($dataSaida == "") {
            $this->mensagemErro("Data de saída inválida");
        }
        if (($destino == "NULL" || $destino == "" || $destinoAlternativo !== "NULL") && ($destino !== "NULL" || $destinoAlternativo === "")) {
            $this->mensagemErro("Destino inválido");
        }
        if ($quantidade <= 0) {
            $this->mensagemErro("Quantidade informada inválida");
        }
        $livroDAO = new livroDAO();
        if ($livroDAO->cadastrarSaida($livroID, $responsavel, $destino, $destinoAlternativo, $quantidade, $dataSaida)) {
            $id = $livroDAO->obterUltimoIdInserido();
            $livroDAO->registrarCadastroSaida($id);
            $this->mensagemSucesso("Saída registrada");
        } else {
            $this->mensagemErro("Erro ao cadastrar no banco");
        }
    }

}

$registrarSaida = new registrarSaida();
$registrarSaida->verificar();
?>