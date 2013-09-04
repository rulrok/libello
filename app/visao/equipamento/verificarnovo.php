<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Equipamento.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovo extends verificadorFormularioAjax {

    public function _validar() {
        $nomeEquipamento = $_POST['equipamento'];
        $dataEntrada = $_POST['dataEntrada'];
        $quantidade = $_POST['quantidade'];
        $tipo = $_POST['tipo'];
        $numeroPatrimonio;

        //Vai validar os dados
        try {
            $equipamento = new Equipamento();

            $equipamento->set_nomeEquipamento($nomeEquipamento)->set_dataEntrada($dataEntrada);

            if ($tipo == "patrimonio") {
                $quantidade = $_POST['quantidadePatrimonios'];

                $colecaoEquipamentos;
                $aux = new Equipamento();
                for ($i = 0; $i < $quantidade; $i++) {
                    //TODO Verificar uma forma
                    $aux = clone $equipamento;
                    $numeroPatrimonio = $_POST['numeroPatrimonio-' . ($i + 1)];
                    $colecaoEquipamentos[$i] = $aux->set_numeroPatrimonio($numeroPatrimonio)->set_quantidadde(1);
                    try {
                        equipamentoDAO::cadastrarEquipamento($aux);
                        $this->mensagem->set_mensagem("Cadastrado com sucesso.")->set_status(Mensagem::SUCESSO);
                    } catch (Exception $e) {
                        $this->mensagem->set_mensagem("Erro ao cadastrar no banco de dados.")->set_status(Mensagem::ERRO);
                    }
                }
            } else {
                //É do tipo custeio
                $equipamento->set_quantidadde($quantidade);
                $equipamento->set_numeroPatrimonio(null);
                //Vai tentar cadastrar
                try {
                    equipamentoDAO::cadastrarEquipamento($equipamento);
                    $this->mensagem->set_mensagem("Cadastrado com sucesso.")->set_status(Mensagem::SUCESSO);
                } catch (Exception $e) {
                    $this->mensagem->set_mensagem("Erro ao cadastrar no banco de dados.")->set_status(Mensagem::ERRO);
                }
            }
        } catch (Exception $e) {
            //Mensagem de erro gerada pela classe Equipamento.
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
    }

}

$verificar = new verificarnovo();
$verificar->verificar();

?>
