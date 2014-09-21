<?php

namespace app\modelo\ferramentas\equipamentos;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

//TODO Revisar o código desse arquivo
class verificarnovo extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $nomeEquipamento = filter_input(INPUT_POST, 'equipamento');
        $descricao = filter_input(INPUT_POST, 'descricoes');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $numeroPatrimonio;


        $equipamento = new Modelo\Equipamento();

        $equipamento->set_nomeEquipamento($nomeEquipamento)->set_dataEntrada($dataEntrada)->set_descricao($descricao);

        if ($tipo == "patrimonio") {
//            $quantidade = filter_input(INPUT_POST, 'quantidadePatrimonios');
            $quantidade = filter_input(INPUT_POST, 'quantidadePatrimoniosInput');


//            $colecaoEquipamentos = [];
            $aux = new Modelo\Equipamento();
            $patrimoniosValidos = 'Patrimônios ';
            $patrimoniosInvalidos = '';
            $equipamentoDAO = new Modelo\equipamentoDAO();
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
                    //TODO Agora é possível mandar pop-ups separados para cada erro
                    //TODO Talvez seja mais interessante do que mandar todos dentro de um único pop-up
                    $patrimoniosInvalidos .= "<li>" . $numeroPatrimonio . "</li>";
                }
            }
            if ($patrimoniosInvalidos === '') {
                //Todos foram cadastrados com sucesso
                $this->adicionarMensagemSucesso("Todos os patrimônios foram cadastrados com sucesso");
            } else {
                //Alguns não puderam ser cadastrados
                $this->adicionarMensagemAviso("Os patrimônios:<br/><ul style=\"text-align: left;\"> " . $patrimoniosInvalidos . "</ul>não puderam ser cadastrados.<br/>Verifique se os mesmos já não foram cadastrados!");
            }
        } else {
            if ($quantidade > 0) {
                //É do tipo custeio
                $equipamento->set_quantidade($quantidade);
                $equipamento->set_numeroPatrimonio(null);
                //Vai tentar cadastrar
                try {
                    $equipamentoDAO = new Modelo\equipamentoDAO();
                    $equipamentoDAO->cadastrarEquipamento($equipamento);
                    $id = $equipamentoDAO->obterUltimoIdInserido();
                    $equipamentoDAO->registrarInsercaoEquipamento($id);
                    $this->adicionarMensagemSucesso("Cadastrado com sucesso.");
                } catch (Exception $e) {
                    $this->adicionarMensagemErro("Erro ao cadastrar no banco de dados.");
                    $this->abortarExecucao();
                }
            } else {
                $this->adicionarMensagemErro("Quantidade deve ser maior que 0");
                $this->abortarExecucao();
            }
        }
    }

}

//$verificar = new verificarnovoequipamento();
//$verificar->executar();
?>
