<?php

require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Equipamento.php";
require_once APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarnovoequipamento extends verificadorFormularioAjax {

    public function _validar() {
        $nomeEquipamento = filter_input(INPUT_POST, 'equipamento');
        $descricao = filter_input(INPUT_POST, 'descricoes');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $numeroPatrimonio;


        $equipamento = new Equipamento();

        $equipamento->set_nomeEquipamento($nomeEquipamento)->set_dataEntrada($dataEntrada)->set_descricao($descricao);

        if ($tipo == "patrimonio") {
//            $quantidade = filter_input(INPUT_POST, 'quantidadePatrimonios');
            $quantidade = filter_input(INPUT_POST, 'quantidadePatrimoniosInput');
            

//            $colecaoEquipamentos = [];
            $aux = new Equipamento();
            $patrimoniosValidos = 'Patrimônios ';
            $patrimoniosInvalidos = '';
            $equipamentoDAO = new equipamentoDAO();
            for ($i = 0; $i < $quantidade; $i++) {
                //TODO Verificar uma forma
                $aux = clone $equipamento;
                $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio-' . ($i + 1));
                $aux->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade(1);
                try {
                    //TODO aplicar transacoes aqui
                    $equipamentoDAO->cadastrarEquipamento($aux);
                    $id = $equipamentoDAO->obterUltimoIdInserido();
                    $equipamentoDAO->registrarInsercaoEquipamento($id);
                    $patrimoniosValidos .= $numeroPatrimonio . "<br/>";
                } catch (Exception $e) {
                    $patrimoniosInvalidos .= "<li>" . $numeroPatrimonio . "</li>";
                }
            }
            if ($patrimoniosInvalidos === '') {
                //Todos foram cadastrados com sucesso
                $this->mensagemSucesso("Todos os patrimônios foram cadastrados com sucesso");
            } else {
                //Alguns não puderam ser cadastrados
                $this->mensagemAviso("Os patrimônios:<br/><ul style=\"text-align: left;\"> " . $patrimoniosInvalidos . "</ul>não puderam ser cadastrados.<br/>Verifique se os mesmos já não foram cadastrados!");
            }
        } else {
            if ($quantidade > 0) {
                //É do tipo custeio
                $equipamento->set_quantidade($quantidade);
                $equipamento->set_numeroPatrimonio(null);
                //Vai tentar cadastrar
                try {
                    $equipamentoDAO = new equipamentoDAO();
                    $equipamentoDAO->cadastrarEquipamento($equipamento);
                    $id = $equipamentoDAO->obterUltimoIdInserido();
                    $equipamentoDAO->registrarInsercaoEquipamento($id);
                    $this->mensagemSucesso("Cadastrado com sucesso.");
                } catch (Exception $e) {
                    $this->mensagemErro("Erro ao cadastrar no banco de dados.");
                }
            } else {
                $this->mensagemErro("Quantidade deve ser maior que 0");
            }
        }
    }

}

$verificar = new verificarnovoequipamento();
$verificar->verificar();
?>
