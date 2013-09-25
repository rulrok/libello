<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/controle-cead/biblioteca/Mvc/Controlador.php';
include_once BIBLIOTECA_DIR . "seguranca/criptografia.php";
include_once ROOT . 'app/modelo/ComboBoxAreas.php';
include_once ROOT . 'app/modelo/ComboBoxCurso.php';

require_once APP_LOCATION . "modelo/Mensagem.php";
require_once APP_LOCATION . "modelo/vo/Polo.php";
require_once APP_LOCATION . "modelo/vo/Curso.php";
require_once APP_LOCATION . "visao/verificadorFormularioAjax.php";

class ControladorCursospolos extends Controlador {

    public function acaoNovoPolo() {

        $this->renderizar();
    }

    public function acaoVerificarNovoPolo() {

        $this->renderizar();
    }

    public function acaoNovoCurso() {
        $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
        $this->visao->comboTipoCurso = ComboBoxCurso::montarTodosOsTipos();
        $this->renderizar();
    }

    public function acaoVerificarNovoCurso() {

        $this->renderizar();
    }

    public function acaoGerenciarcursos() {
        $this->visao->cursos = cursoDAO::consultar("idCurso,nome,nomeArea,nomeTipoCurso");
        $i = 0;
        foreach ($this->visao->cursos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->cursos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoGerenciarpolos() {
        $this->visao->polos = poloDAO::consultar("idPolo,nome,cidade,estado");
        $i = 0;
        foreach ($this->visao->polos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->polos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditarCurso() {
        if (isset($_GET['cursoID']) || isset($_POST['cursoID'])) {
            $this->visao->comboArea = ComboBoxAreas::montarTodasAsAreas();
            $this->visao->comboTipoCurso = ComboBoxTipoCurso::montarTodosOsTipos();
            $cursoID = fnDecrypt($_REQUEST['cursoID']);
            $this->visao->cursoID = $_REQUEST['cursoID'];
            $curso = cursoDAO::recuperarCurso($cursoID);
            $this->visao->curso = $curso->get_nome();
            $this->visao->idArea = (int) $curso->get_area();
            $this->visao->idTipoCurso = (int) $curso->get_tipo();
        } else {
            die("Acesso indevido");
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
            $poloID = fnDecrypt($_REQUEST['poloID']);
            $this->visao->poloID = $_REQUEST['poloID'];
            $polo = poloDAO::recuperarPolo($poloID);
            $this->visao->polo = $polo->get_nome();
            $this->visao->cidade = $polo->get_cidade();
            $this->visao->estado = $polo->get_estado();
        } else {
            die("Acesso indevido");
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicaoPolo() {
        $this->renderizar();
    }

}

?>
