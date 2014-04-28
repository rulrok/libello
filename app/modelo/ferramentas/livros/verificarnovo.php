<?php

require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Livro.php";
require_once APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarnovolivro extends verificadorFormularioAjax {

    public function _validar() {
        $nomelivro = filter_input(INPUT_POST, 'livro');
        $descricao = filter_input(INPUT_POST, 'descricoes');
        $dataEntrada = filter_input(INPUT_POST, 'dataEntrada');
        $quantidade = filter_input(INPUT_POST, 'quantidade');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $grafica = filter_input(INPUT_POST, 'grafica');
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);



        $livro = new livro();

        if ($nomelivro == "") {
            $this->mensagemErro("Nome inválido");
        }
//        if ($dataEntrada == "") {
//            $this->mensagemErro("Data de entrada inválida");
//        }
        if (!is_int($area)) {
            $this->mensagemErro("Área inválida");
        }
        if ($grafica == "") {
            $this->mensagemErro("Nome da gráfica inválido");
        }
        $livro->set_nomelivro($nomelivro)->set_dataEntrada($dataEntrada)->set_descricao($descricao)->set_area($area)->set_grafica($grafica);

        $livroDAO = new livroDAO();
        if ($tipo == "patrimonio") {

            $quantidadePatrimonios = filter_input(INPUT_POST, 'quantidadePatrimonios');

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
                $this->mensagemSucesso("Todos os patrimônios foram cadastrados com sucesso");
            } else {
                //Alguns não puderam ser cadastrados
                $this->mensagemAviso("Os patrimônios:<br/><ul style=\"text-align: left;\"> " . $patrimoniosInvalidos . "</ul>não puderam ser cadastrados.<br/>Verifique se os mesmos já não foram cadastrados!");
            }
        } else {
            if ($quantidade <= 0) {
                $this->mensagemErro("Quantidade deve ser maior que 0");
            }
            //É do tipo custeio
            $livro->set_quantidade($quantidade);
            $livro->set_numeroPatrimonio(null);
            //Vai tentar cadastrar
            if ($livroDAO->cadastrarlivro($livro)) {
                $id = $livroDAO->obterUltimoIdInserido();
                $livroDAO->registrarInsercaolivro($id);
                $this->mensagemSucesso("Cadastrado com sucesso.");
            } else {
                $this->mensagemErro("Erro ao cadastrar no banco de dados.");
            }
        }
    }

}

$verificar = new verificarnovolivro();
$verificar->verificar();
?>
