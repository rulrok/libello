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
            $descricao = $_POST['descricao'];
            $numeroPatrimonio = $_POST['numeroPatrimonio'];
            $tipoEquipamento = $_POST['tipo'];

            if ($equipamentoNome != "") {
                $equipamento = equipamentoDAO::recuperarEquipamento($equipamentoID);

                $numPatrimonio = $equipamento->get_numeroPatrimonio();
                
//                $this->mensagem->set_mensagem(print_r($equipamento,true));
//                return;
                if ($tipoEquipamento === "custeio") {
                    if (($numPatrimonio != "") && !equipamentoDAO::equipamentoPodeTerTipoAlterado($equipamentoID)) {
                        $this->mensagem->set_mensagem("Não é possível alterar o tipo")->set_status(Mensagem::ERRO);
                        return;
                    }
                    //É um item de custeio
                    $numeroPatrimonio = null;
                } else {
                    if ($numPatrimonio === "NULL" && !equipamentoDAO::equipamentoPodeTerTipoAlterado($equipamentoID)) {
                        $this->mensagem->set_mensagem("Não é possível alterar o tipo")->set_status(Mensagem::ERRO);
                        return;
                    }
                    //É um patrimônio
                    $quantidade = 1;
                }
                if ($quantidade > 0) {
                    $equipamento->set_nomeEquipamento($equipamentoNome)->set_dataEntrada($dataEntrada)->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade($quantidade)->set_descricao($descricao);

                    if (equipamentoDAO::atualizar($equipamentoID, $equipamento)) {
                        equipamentoDAO::registrarAlteracaoEquipamento($equipamentoID);
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
