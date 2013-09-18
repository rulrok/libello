<?php

require_once APP_LOCATION . "modelo/vo/Equipamento.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarEdicao extends verificadorFormularioAjax {

    public function _validar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;

            $equipamentoID = fnDecrypt($_POST['equipamentoID']);
            $equipamentoNome = $_POST['equipamento'];
            $dataEntrada = $_POST['dataEntrada'];
            $quantidade = $_POST['quantidade'];
            $numeroPatrimonio = $_POST['numeroPatrimonio'];
            $tipoEquipamento = $_POST['tipo'];

            if ($equipamentoNome != "") {
                $equipamento = equipamentoDAO::recuperarEquipamento($equipamentoID);

                if ($tipoEquipamento === "custeio") {
                    //É um item de custeio
                    $numeroPatrimonio = null;
                } else {
                    //É um patrimônio
                    $quantidade = 1;
                }
                if ($quantidade > 0) {
                    $equipamento->set_nomeEquipamento($equipamentoNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade);

                    if (equipamentoDAO::atualizar($equipamentoID, $equipamento)) {
                        $this->mensagem->set_mensagem("Atualizado com sucesso");
                        $this->mensagem->set_status(Mensagem::SUCESSO);
                    } else {
                        $this->mensagem->set_mensagem("Um erro ocorreu ao cadastrar no banco");
                        $this->mensagem->set_status(Mensagem::ERRO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Quantidade deve ser maior que 0");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            } else {
                $this->mensagem->set_mensagem("Nome inválido");
                $this->mensagem->set_status(Mensagem::ERRO);
            }
        endif;
    }

}

$verificarEdicao = new verificarEdicao();
$verificarEdicao->verificar();
?>
