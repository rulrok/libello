<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once ROOT . 'app/modelo/ComboBoxAreas.php';
include_once ROOT . 'app/modelo/ComboBoxTipoCurso.php';

class ControladorCursospolos extends Controlador {

    public function acaoNovoPolo($erro = false) {
        if (!$erro) {
            $this->visao->nome = '';
            $this->visao->estado = '';
            $this->visao->cidade = '';
        }
        $this->renderizar();
    }

    public function acaoVerificarNovoPolo() {
        $this->visao->mensagem_usuario = null;
        $this->visao->tipo_mensagem = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
        endif;
        $this->visao->estado = $_POST['estado'];
        $this->visao->cidade = $_POST['cidade'];
        $this->visao->nome = $_POST['nomepolo'];

        if (!strpos($this->visao->estado, "selecione")) {
            if (!strpos($this->visao->cidade, "selecione")) {
                if (strcmp($this->visao->nome, "") != 0) {
                    $polo = new Polo();
                    $polo->set_nome($this->visao->nome);
                    $polo->set_cidade($this->visao->cidade);
                    $polo->set_estado($this->visao->estado);
                    $this->visao->mensagem_usuario = "Cadastrado com sucesso";
                    $this->visao->tipo_mensagem = "sucesso";
                    if (poloDAO::consultarPolo($polo) == 0) {
                        poloDAO::cadastrarPolo($polo);
                        $this->acaoNovoPolo(false);
                    } else {
                        $this->visao->mensagem_usuario = "Polo já existe!";
                        $this->visao->tipo_mensagem = "informacao";
                        $this->acaoNovoPolo(true);
                    }
                } else {
                    $this->visao->mensagem_usuario = "Erro ao cadastrar";
                    $this->visao->tipo_mensagem = "erro";
                    $this->acaoNovoPolo(true);
                }
            } else {
                $this->visao->mensagem_usuario = "Erro ao cadastrar";
                $this->visao->tipo_mensagem = "erro";
                $this->acaoNovoPolo(true);
            }
        } else {
            $this->visao->mensagem_usuario = "Erro ao cadastrar";
            $this->visao->tipo_mensagem = "erro";
            $this->acaoNovoPolo(true);
        }

        return;
    }

    public function acaoNovoCurso($erro = false) {
        if (!$erro) {
            $this->visao->curso = "";
        }
        $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
        $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();
        $this->renderizar();
    }

    public function acaoVerificarNovoCurso() {
        $this->visao->mensagem_usuario = null;
        $this->visao->tipo_mensagem = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
        endif;
        $this->visao->curso = $_POST['curso'];
        $this->visao->area = $_POST['area'];
        $this->visao->tipocurso = $_POST['tipocurso'];

        if (!strpos($this->visao->tipocurso, "selecione")) {
            if (!strpos($this->visao->area, "selecione")) {
                if (strcmp($this->visao->curso, "") != 0) {
                    $curso = new Curso();
                    $curso->set_nome($this->visao->curso);
                    $curso->set_area($this->visao->area);
                    $curso->set_tipo($this->visao->tipocurso);
                    if (cursoDAO::consultarCurso($curso) == 0) {
                        cursoDAO::cadastrarCurso($curso);
                        $this->visao->mensagem_usuario = "Cadastrado com sucesso";
                        $this->visao->tipo_mensagem = "sucesso";
                        $this->acaoNovoCurso(false);
                    } else {
                        $this->visao->mensagem_usuario = "Polo já existe!";
                        $this->visao->tipo_mensagem = "informacao";
                        $this->acaoNovoCurso(true);
                    }
                } else {
                    $this->visao->mensagem_usuario = "Erro ao cadastrar";
                    $this->visao->tipo_mensagem = "erro";
                    $this->acaoNovoCurso(true);
                }
            } else {
                $this->visao->mensagem_usuario = "Erro ao cadastrar";
                $this->visao->tipo_mensagem = "erro";
                $this->acaoNovoCurso(true);
            }
        } else {
            $this->visao->mensagem_usuario = "Erro ao cadastrar";
            $this->visao->tipo_mensagem = "erro";
            $this->acaoNovoCurso(true);
        }

        return;
    }

    public function acaoGerenciarcursos() {
        $this->renderizar();
    }

    public function acaoGerenciarpolos() {
        $this->renderizar();
    }

}

?>
