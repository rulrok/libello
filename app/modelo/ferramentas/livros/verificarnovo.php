<?php

namespace app\modelo\ferramentas\livros;

include_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class verificarnovo extends Modelo\verificadorFormularioAjax {

    public function _validar() {
        $nomelivro = filter_input(INPUT_POST, 'livro');
        $descricao = filter_input(INPUT_POST, 'descricoes');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $grafica = filter_input(INPUT_POST, 'grafica');
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);



        $livro = new Modelo\Livro();

        if ($nomelivro == "") {
            $this->adicionarMensagemErro("Nome inválido");
        }
//        if ($dataEntrada == "") {
//            $this->mensagemErro("Data de entrada inválida");
//        }
        if (!is_int($area)) {
            $this->adicionarMensagemErro("Área inválida");
        }
        if ($grafica == "") {
            $this->adicionarMensagemErro("Nome da gráfica inválido");
        }
        $livro->set_nomelivro($nomelivro)->set_dataEntrada($dataEntrada)->set_descricao($descricao)->set_area($area)->set_grafica($grafica);

        $livroDAO = new Modelo\livroDAO();
        if ($tipo == "patrimonio") {

//            $quantidadePatrimonios = filter_input(INPUT_POST, 'quantidadePatrimonios');
            $quantidadePatrimonios = filter_input(INPUT_POST, 'quantidadePatrimoniosInput');

//                $colecaolivros = [];
            $aux = new livro();
            $patrimoniosValidos = 'Patrimônios ';
            $patrimoniosInvalidos = '';
            $numeroPatrimonio;
            for ($i = 0; $i < $quantidadePatrimonios; $i++) {
                $aux = clone $livro;
                $numeroPatrimonio = filter_input(INPUT_POST, 'numeroPatrimonio-' . ($i + 1));
                $aux->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade(1);

                if ($livroDAO->cadastrarlivro($aux)) {
                    $id = $livroDAO->obterUltimoIdInserido();
                    $livroDAO->registrarInsercaolivro($id);
                    $patrimoniosValidos .= $numeroPatrimonio . "<br/>";
                } else {
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
            if ($quantidade <= 0) {
                $this->adicionarMensagemErro("Quantidade deve ser maior que 0");
            }
            //É do tipo custeio
            $livro->set_quantidade($quantidade);
            $livro->set_numeroPatrimonio(null);
            //Vai tentar cadastrar
            if ($livroDAO->cadastrarlivro($livro)) {
                $id = $livroDAO->obterUltimoIdInserido();
//                $livroDAO->registrarInsercaolivro($id);
                $this->adicionarMensagemSucesso("Cadastrado com sucesso.");
            } else {
                $this->adicionarMensagemErro("Erro ao cadastrar no banco de dados.");
            }
        }
    }

}

//$verificar = new verificarnovolivro();
//$verificar->executar();
?>
