<?php

namespace app\controlador;

include_once APP_LIBRARY_DIR . 'Mvc/Controlador.php';
include_once APP_LIBRARY_DIR . "seguranca/criptografia.php";
include_once APP_LIBRARY_DIR . "seguranca/Permissao.php";

require_once APP_DIR . "modelo/dao/CursoDAO.php";
require_once APP_DIR . "modelo/dao/PoloDAO.php";
include_once APP_DIR . 'modelo/comboboxes/ComboBoxAreas.php';
include_once APP_DIR . 'modelo/comboboxes/ComboBoxCurso.php';
require_once APP_DIR . "modelo/Mensagem.php";
require_once APP_DIR . "modelo/vo/Polo.php";
require_once APP_DIR . "modelo/vo/Curso.php";
require_once APP_DIR . "modelo/enumeracao/Ferramenta.php";
require_once APP_DIR . "modelo/verificadorFormularioAjax.php";

use \app\modelo as Modelo;

class ControladorCursospolos extends Controlador {

    public function acaoNovoPolo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoVerificarNovoPolo() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoNovoCurso() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->visao->comboArea = Modelo\ComboBoxAreas::montarTodasAsAreas();
        $this->visao->comboTipoCurso = Modelo\ComboBoxCurso::montarTodosOsTipos();
        $this->renderizar();
    }

    public function acaoVerificarNovoCurso() {
        $this->visao->acessoMinimo = Modelo\Permissao::ESCRITA;
        $this->renderizar();
    }

    public function acaoGerenciarcursos() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->cursos = (new Modelo\cursoDAO())->consultar("idCurso, nomeCurso, nomeArea, nomeTipoCurso");
        $i = 0;
        foreach ($this->visao->cursos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->cursos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoGerenciarpolos() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->visao->polos = (new Modelo\poloDAO())->consultar("idPolo,nomePolo,cidade,estado");
        $i = 0;
        foreach ($this->visao->polos as $value) {
            $value[0] = fnEncrypt($value[0]);
            $this->visao->polos[$i++] = $value;
        }
        $this->renderizar();
    }

    public function acaoEditarCurso() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        if (isset($_GET['cursoID']) || isset($_POST['cursoID'])) {
            $this->visao->comboArea = Modelo\ComboBoxAreas::montarTodasAsAreas();
            $this->visao->comboTipoCurso = Modelo\ComboBoxCurso::montarTodosOsTipos();
            $cursoID = fnDecrypt($_REQUEST['cursoID']);
            $this->visao->cursoID = $_REQUEST['cursoID'];
            $curso = (new Modelo\cursoDAO())->recuperarCurso($cursoID);
            $this->visao->curso = $curso->get_nome();
            $this->visao->idArea = (int) $curso->get_idArea();
            $this->visao->idTipoCurso = (int) $curso->get_idTipo();
        } else {
            die("Acesso indevido");
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicaoCurso() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverCurso() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoRemoverPolo() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function acaoEditarPolo() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        if (isset($_GET['poloID']) || isset($_POST['poloID'])) {
            $poloID = fnDecrypt($_REQUEST['poloID']);
            $this->visao->poloID = $_REQUEST['poloID'];
            $polo = (new Modelo\poloDAO())->recuperarPolo($poloID);
            $this->visao->polo = $polo->get_nome();
            $this->visao->cidade = $polo->get_cidade();
            $this->visao->estadoViagem = $polo->get_estado();
        } else {
            die("Acesso indevido");
        }

        $this->renderizar();
    }

    public function acaoVerificarEdicaoPolo() {
        $this->visao->acessoMinimo = Modelo\Permissao::GESTOR;
        $this->renderizar();
    }

    public function idFerramentaAssociada() {
        return Modelo\Ferramenta::CURSOS_E_POLOS;
    }

}

?>
