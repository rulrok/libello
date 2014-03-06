<?php

include APP_DIR . "visao/verificadorFormularioAjax.php";

class verificarnovodescritor extends verificadorFormularioAjax {

    private function auxiliar_ultimo_id_inserido(imagensDAO $dao, $nomeDescritor) {
        $resultado = $dao->consultarDescritor("idDescritor", "nome = '$nomeDescritor' ORDER BY idDescritor DESC LIMIT 1");
        return $resultado[0][0];
    }

    public function _validar() {
        if (filter_has_var(INPUT_POST, 'inserir_novo_descritor_1')) {
            //Vai cadastrar desde a raiz
            $nomeDescritor1 = filter_input(INPUT_POST, 'novo_descritor_1');
            $nomeDescritor2 = filter_input(INPUT_POST, 'novo_descritor_2');
            $nomeDescritor3 = filter_input(INPUT_POST, 'novo_descritor_3');
            $nomeDescritor4 = filter_input(INPUT_POST, 'novo_descritor_4');

            if ($nomeDescritor1 == "" || $nomeDescritor2 == "" || $nomeDescritor3 == "" || $nomeDescritor4 == "") {
                $this->mensagemErro("Todos os descritores são obrigatórios.");
            }
            $imagensDAO = new imagensDAO();
            $aux = $imagensDAO->consultarDescritoresNivel1('count(idDescritor)', "nome = '$nomeDescritor1' ");
            if ($aux != null && $aux > 0) {
                $this->mensagemErro("Já existe o descritor '$nomeDescritor1' cadastrado como nível 1.");
            }
            try {
                $imagensDAO->iniciarTransacao();
                //Descritor 1
                $descritor1 = new Descritor();
                $descritor1->set_nome($nomeDescritor1);
                if (!$imagensDAO->cadastrarDescritorNivel1($descritor1)) {
                    throw new Exception("Falha ao cadastrar descritor nível 1");
                }
                /*
                 *  ! IMPORTANTE !
                 *  
                 * O último ID deve ser obtido de forma manual, pois há uma 
                 * trigger que faz inserções (tabelas auxiliares) e dependendo
                 * das versões do softwares usados, não há garantia do que irá
                 * acontecer.
                 * Em resumo: Não usar $this->obterUltimoIdInserido();
                 * 
                 * O que acontece é de procurar pelo descritor que possui o
                 * mesmo nome mais recente inserido, pois a coluna de nomes não
                 * é UNIQUE. Para eficiência, é usado LIMIT 1 com ORDER BY DESC.
                 * Em resumo: O maior ID associado ao nome procurado é buscado.
                 */
                $idDescritor1 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor1);

                //Descritor 2
                $descritor2 = new Descritor();
                $descritor2->set_nome($nomeDescritor2);
                if (!$imagensDAO->cadastrarDescritor($descritor2, $idDescritor1)) {
                    throw new Exception("Falha ao cadastrar descritor nível 2");
                }
                $idDescritor2 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor2);

                //Descritor 3
                $descritor3 = new Descritor();
                $descritor3->set_nome($nomeDescritor3);
                if (!$imagensDAO->cadastrarDescritor($descritor3, $idDescritor2)) {
                    throw new Exception("Falha ao cadastrar descritor nível 3");
                }
                $idDescritor4 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor3);

                //Descritor 4
                $descritor4 = new Descritor();
                $descritor4->set_nome($nomeDescritor4);
                if (!$imagensDAO->cadastrarDescritor($descritor4, $idDescritor4)) {
                    throw new Exception("Falha ao cadastrar descritor nível 4");
                }

                $imagensDAO->encerrarTransacao();
                $this->mensagemSucesso("Cadastrado com sucesso");
            } catch (Exception $e) {
                $imagensDAO->rollback();
                $message = $e->getMessage();
                $this->mensagemErro("Erro:<br/>$message<br/>Nenhuma alteração feita no sistema.");
            }
        } elseif (filter_has_var(INPUT_POST, 'inserir_novo_descritor_2')) {
            //Vai cadastrar a partir do segundo nível
            $idDescritor1 = fnDecrypt(filter_input(INPUT_POST, 'descritor_1'));
            $nomeDescritor2 = filter_input(INPUT_POST, 'novo_descritor_2');
            $nomeDescritor3 = filter_input(INPUT_POST, 'novo_descritor_3');
            $nomeDescritor4 = filter_input(INPUT_POST, 'novo_descritor_4');



            if ($nomeDescritor2 == "" || $nomeDescritor3 == "" || $nomeDescritor4 == "") {
                $this->mensagemErro("Todos os descritores são obrigatórios.");
            }
            $imagensDAO = new imagensDAO();
            $aux = $imagensDAO->consultarDescritor('count(idDescritor)', "pai = $idDescritor1 AND nome = '$nomeDescritor2' ");
            if ($aux != null && $aux > 0) {
                $this->mensagemErro("Já existe o descritor '$nomeDescritor2' cadastrado para esses descritores.");
            }
            try {
                $imagensDAO->iniciarTransacao();

                //Descritor 2
                $descritor2 = new Descritor();
                $descritor2->set_nome($nomeDescritor2);
                if (!$imagensDAO->cadastrarDescritor($descritor2, $idDescritor1)) {
                    throw new Exception("Falha ao cadastrar descritor nível 2");
                }
                $idDescritor2 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor2);

                //Descritor 3
                $descritor3 = new Descritor();
                $descritor3->set_nome($nomeDescritor3);
                if (!$imagensDAO->cadastrarDescritor($descritor3, $idDescritor2)) {
                    throw new Exception("Falha ao cadastrar descritor nível 3");
                }
                $idDescritor3 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor3);

                //Descritor 4
                $descritor4 = new Descritor();
                $descritor4->set_nome($nomeDescritor4);
                if (!$imagensDAO->cadastrarDescritor($descritor4, $idDescritor3)) {
                    throw new Exception("Falha ao cadastrar descritor nível 4");
                }

                $imagensDAO->encerrarTransacao();
                $this->mensagemSucesso("Cadastrado com sucesso");
            } catch (Exception $e) {
                $imagensDAO->rollback();
                $message = $e->getMessage();
                $this->mensagemErro("Erro:<br/>$message<br/>Nenhuma alteração feita no sistema.");
            }
        } elseif (filter_has_var(INPUT_POST, 'inserir_novo_descritor_3')) {
            //Vai cadastrar a partir do terceiro nível
            $idDescritor1 = fnDecrypt(filter_input(INPUT_POST, 'descritor_2'));
            $idDescritor2 = fnDecrypt(filter_input(INPUT_POST, 'descritor_2'));
            $nomeDescritor3 = filter_input(INPUT_POST, 'novo_descritor_3');
            $nomeDescritor4 = filter_input(INPUT_POST, 'novo_descritor_4');
            if ($nomeDescritor3 == "" || $nomeDescritor4 == "") {
                $this->mensagemErro("Todos os descritores são obrigatórios.");
            }
            $imagensDAO = new imagensDAO();
            $aux = $imagensDAO->consultarDescritor('count(idDescritor)', "pai = $idDescritor2 AND nome = '$nomeDescritor3' ");
            if ($aux != null && $aux > 0) {
                $this->mensagemErro("Já existe o descritor '$nomeDescritor3' cadastrado para esses descritores.");
            }
            try {
                $imagensDAO->iniciarTransacao();

                //Descritor 3
                $descritor3 = new Descritor();
                $descritor3->set_nome($nomeDescritor3);
                if (!$imagensDAO->cadastrarDescritor($descritor3, $idDescritor2)) {
                    throw new Exception("Falha ao cadastrar descritor nível 3");
                }
                $idDescritor3 = $this->auxiliar_ultimo_id_inserido($imagensDAO, $nomeDescritor3);

                //Descritor 4
                $descritor4 = new Descritor();
                $descritor4->set_nome($nomeDescritor4);
                if (!$imagensDAO->cadastrarDescritor($descritor4, $idDescritor3)) {
                    throw new Exception("Falha ao cadastrar descritor nível 4");
                }

                $imagensDAO->encerrarTransacao();
                $this->mensagemSucesso("Cadastrado com sucesso");
            } catch (Exception $e) {
                $imagensDAO->rollback();
                $message = $e->getMessage();
                $this->mensagemErro("Erro:<br/>$message<br/>Nenhuma alteração feita no sistema.");
            }
        } else {
            //Vai cadastrar no último nível
            $idDescritor1 = fnDecrypt(filter_input(INPUT_POST, 'descritor_2'));
            $idDescritor2 = fnDecrypt(filter_input(INPUT_POST, 'descritor_2'));
            $idDescritor3 = fnDecrypt(filter_input(INPUT_POST, 'descritor_3'));
            $nomeDescritor4 = filter_input(INPUT_POST, 'novo_descritor_4');
            if ($nomeDescritor4 == "") {
                $this->mensagemErro("Todos os descritores são obrigatórios.");
            }
            $imagensDAO = new imagensDAO();
            $aux = $imagensDAO->consultarDescritor('count(idDescritor)', "pai = $idDescritor3 AND nome = '$nomeDescritor4' ");
            if ($aux != null && $aux > 0) {
                $this->mensagemErro("Já existe o descritor '$nomeDescritor4' cadastrado para esses descritores.");
            }
            try {
                $imagensDAO->iniciarTransacao();

                //Descritor 4
                $descritor4 = new Descritor();
                $descritor4->set_nome($nomeDescritor4);
                if (!$imagensDAO->cadastrarDescritor($descritor4, $idDescritor3)) {
                    throw new Exception("Falha ao cadastrar descritor nível 4");
                }

                $imagensDAO->encerrarTransacao();
                $this->mensagemSucesso("Cadastrado com sucesso");
            } catch (Exception $e) {
                $imagensDAO->rollback();
                $message = $e->getMessage();
                $this->mensagemErro("Erro:<br/>$message<br/>Nenhuma alteração feita no sistema.");
            }
        }
    }

}

$verificarnovodescritor = new verificarnovodescritor();
$verificarnovodescritor->verificar();
