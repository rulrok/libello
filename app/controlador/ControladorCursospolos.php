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
        $this->visao->curso = $_POST['nomecurso'];
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
//                        $this->visao->id
//                        $this->visao->idArea = areaDAO::obterIdArea($this->visao->area);
//                        $this->visao->idTipoCurso = cursoDAO::obterIdCurso($this->visao->tipocurso);
                        $this->visao->mensagem_usuario = "Curso já existe!";
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
        $this->visao->cursos = cursoDAO::consultar("idCurso,nome,nomeArea,nomeTipoCurso");
        $this->renderizar();
    }

    public function acaoGerenciarpolos() {
        $this->visao->polos = poloDAO::consultar("idPolo,nome,cidade,estado");
        $this->renderizar();
    }

    public function acaoEditarCurso($erro = false) {
        if ($erro == false) {
            if (isset($_GET['cursoID']) || isset($_POST['cursoID'])) {
                $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
                $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();
                $this->visao->cursoID = $cursoID = $_REQUEST['cursoID'];
                $curso = cursoDAO::recuperarCurso($cursoID);
                $this->visao->curso = $curso->get_nome();
                $this->visao->idArea = (int) $curso->get_area();
                $this->visao->idTipoCurso = (int) $curso->get_tipo();
            }
        }
        $this->renderizar();
    }

    public function acaoVerificarEdicaoCurso($erro = false) {
        $this->visao->mensagem_usuario = null;
        $this->visao->tipo_mensagem = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;
            $this->visao->cursoID = $_POST['cursoID'];
            $this->visao->curso = $_POST['nomecurso'];
            $this->visao->area = $_POST['area'];
            $this->visao->tipoCurso = $_POST['tipocurso'];

            $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
            $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();


            $cursoNovo = new Curso();
            $cursoNovo->set_nome($this->visao->curso);
            $cursoNovo->set_area($this->visao->area);
            $cursoNovo->set_tipo($this->visao->tipoCurso);

            $curso = cursoDAO::recuperarCurso($this->visao->cursoID);

            if ($curso->get_nome() != "") {

                if (cursoDAO::atualizar($this->visao->cursoID, $cursoNovo)) {
                    $this->visao->mensagem_usuario = "Atualização concluída";
                    $this->visao->tipo_mensagem = 'sucesso';
                    $this->acaoEditarCurso(false);
                } else {
                    $this->visao->mensagem_usuario = "Atualização mal sucedida";
                    $this->visao->tipo_mensagem = 'erro';
                    $this->acaoEditarCurso(true);
                }
            } else {
                $this->visao->mensagem_usuario = "Dados inconsistentes";
                $this->visao->tipo_mensagem = 'erro';
                $this->acaoEditarCurso(true);
            }

        endif;

        return;
    }

    public function acaoRemoverCurso() {
        $this->renderizar();
    }

    public function acaoRemoverPolo() {
        $this->renderizar();
    }

    public function acaoEditarPolo($erro = false) {
        if ($erro == false) {
            if (isset($_GET['poloID']) || isset($_POST['poloID'])) {
                $this->visao->poloID = $cursoID = $_REQUEST['poloID'];
                $polo = poloDAO::recuperarPolo($this->visao->poloID);
                $this->visao->polo = $polo->get_nome();
                $this->visao->cidade = $polo->get_cidade();
                $this->visao->estado = $polo->get_estado();
            }
        }
        $this->renderizar();
    }

    public function acaoVerificarEdicaoPolo($erro = false) {
        $this->visao->mensagem_usuario = null;
        $this->visao->tipo_mensagem = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $_SERVER['REQUEST_METHOD'] = null;

            $this->visao->poloID = $_POST['poloID'];
            $this->visao->polo = $_POST['polo'];
            $this->visao->estado = $_POST['estado'];
            $this->visao->cidade = $_POST['cidade'];

            $poloNovo = new Polo();
            $poloNovo->set_nome($this->visao->polo);
            $poloNovo->set_estado($this->visao->estado);
            $poloNovo->set_cidade($this->visao->cidade);

            $polo = poloDAO::recuperarPolo($this->visao->poloID);

            if ($polo->get_nome() != "") {

                if (poloDAO::atualizar($this->visao->poloID, $poloNovo)) {
                    $this->visao->mensagem_usuario = "Atualização concluída";
                    $this->visao->tipo_mensagem = 'sucesso';
                    $this->acaoEditarPolo(false);
                } else {
                    $this->visao->mensagem_usuario = "Atualização mal sucedida";
                    $this->visao->tipo_mensagem = 'erro';
                    $this->acaoEditarPolo(true);
                }
            } else {
                $this->visao->mensagem_usuario = "Dados inconsistentes";
                $this->visao->tipo_mensagem = 'erro';
                $this->acaoEditarPolo(true);
            }

        endif;

        return;
    }

}

?>