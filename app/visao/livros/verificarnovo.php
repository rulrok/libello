<?php

include APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Livro.php";
include APP_LOCATION . "visao/verificadorFormularioAjax.php";

class verificarnovolivro extends verificadorFormularioAjax {

    public function _validar() {
        $nomelivro = $_POST['livro'];
        $descricao = $_POST['descricoes'];
        $dataEntrada = $_POST['dataEntrada'];
        $quantidade = $_POST['quantidade'];
        $tipo = $_POST['tipo'];
        $grafica = $_POST['grafica'];
        $area = $_POST['area'];
        $numeroPatrimonio;

        //Vai validar os dados
        try {
            $livro = new livro();

            $livro->set_nomelivro($nomelivro)->set_dataEntrada($dataEntrada)->set_descricao($descricao);

            if ($tipo == "patrimonio") {
                $quantidade = $_POST['quantidadePatrimonios'];

                $colecaolivros = [];
                $aux = new livro();
                $patrimoniosValidos = 'Patrimônios ';
                $patrimoniosInvalidos = '';
                for ($i = 0; $i < $quantidade; $i++) {
                    $aux = clone $livro;
                    $numeroPatrimonio = $_POST['numeroPatrimonio-' . ($i + 1)];
                    /*$colecaolivros[$i] = */$aux->set_numeroPatrimonio($numeroPatrimonio)->set_quantidade(1)->set_grafica($grafica)->set_area($area);
                    try {
                        $id = livroDAO::cadastrarlivro($aux);
                        livroDAO::registrarInsercaolivro($id);
                        $patrimoniosValidos .= $numeroPatrimonio . "<br/>";
                    } catch (Exception $e) {
                        $patrimoniosInvalidos .= "<li>" . $numeroPatrimonio . "</li>";
                    }
                }
                if ($patrimoniosInvalidos === '') {
                    //Todos foram cadastrados com sucesso
                    $this->mensagem->set_mensagem("Todos os patrimônios foram cadastrados com sucesso")->set_status(Mensagem::SUCESSO);
                } else {
                    //Alguns não puderam ser cadastrados
                    $this->mensagem->set_mensagem("Os patrimônios:<br/><ul style=\"text-align: left;\"> " . $patrimoniosInvalidos . "</ul>não puderam ser cadastrados.<br/>Verifique se os mesmos já não foram cadastrados!")->set_status(Mensagem::INFO);
                }
            } else {
                if ($quantidade > 0) {
                    //É do tipo custeio
                    $livro->set_quantidade($quantidade);
                    $livro->set_numeroPatrimonio(null);
                    $livro->set_grafica($grafica);
                    $livro->set_area($area);
                    //Vai tentar cadastrar
                    try {
                        $id = livroDAO::cadastrarlivro($livro);
                        livroDAO::registrarInsercaolivro($id);
                        $this->mensagem->set_mensagem("Cadastrado com sucesso.")->set_status(Mensagem::SUCESSO);
                    } catch (Exception $e) {
                        $this->mensagem->set_mensagem("Erro ao cadastrar no banco de dados.")->set_status(Mensagem::ERRO);
                    }
                } else {
                    $this->mensagem->set_mensagem("Quantidade deve ser maior que 0");
                    $this->mensagem->set_status(Mensagem::ERRO);
                }
            }
        } catch (Exception $e) {
            //Mensagem de erro gerada pela classe livro.
            $this->mensagem->set_mensagem($e->getMessage())->set_status(Mensagem::ERRO);
        }
    }

}

$verificar = new verificarnovolivro();
$verificar->verificar();
?>
