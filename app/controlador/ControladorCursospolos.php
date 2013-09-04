<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once ROOT . 'app/modelo/ComboBoxAreas.php';
include_once ROOT . 'app/modelo/ComboBoxTipoCurso.php';

class ControladorCursospolos extends Controlador {

    public function acaoNovoPolo() {

        $this->renderizar();
    }

    public function acaoVerificarNovoPolo() {

        $this->renderizar();
    }

    public function acaoNovoCurso() {
        $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
        $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();
        $this->renderizar();
    }

    public function acaoVerificarNovoCurso() {

        $this->renderizar();
    }

    public function acaoGerenciarcursos() {
        $this->visao->cursos = cursoDAO::consultar("idCurso,nome,nomeArea,nomeTipoCurso");
        $this->renderizar();
    }

    public function acaoGerenciarpolos() {
        $this->visao->polos = poloDAO::consultar("idPolo,nome,cidade,estado");
        $this->renderizar();
    }

    public function acaoEditarCurso() {
        if (isset($_GET['cursoID']) || isset($_POST['cursoID'])) {
            $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
            $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();
            $this->visao->cursoID = $cursoID = $_REQUEST['cursoID'];
            $curso = cursoDAO::recuperarCurso($cursoID);
            $this->visao->curso = $curso->get_nome();
            $this->visao->idArea = (int) $curso->get_area();
            $this->visao->idTipoCurso = (int) $curso->get_tipo();
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicaoCurso() {
        $this->renderizar();
    }

    public function acaoRemoverCurso() {
        $this->renderizar();
    }

    public function acaoRemoverPolo() {
        $this->renderizar();
    }

    public function acaoEditarPolo() {
        if (isset($_GET['poloID']) || isset($_POST['poloID'])) {
            $this->visao->poloID = $cursoID = $_REQUEST['poloID'];
            $polo = poloDAO::recuperarPolo($this->visao->poloID);
            $this->visao->polo = $polo->get_nome();
            $this->visao->cidade = $polo->get_cidade();
            $this->visao->estado = $polo->get_estado();
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicaoPolo() {

        $this->renderizar();
    }

}

?>
