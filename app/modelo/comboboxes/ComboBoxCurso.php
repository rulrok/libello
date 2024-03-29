<?php

namespace app\modelo;

require_once APP_LIBRARY_DIR . "configuracoes.php";
include_once APP_DIR . 'modelo/dao/cursoDAO.php';
require_once APP_DIR . 'modelo/enumeracao/TipoCurso.php';

use \app\modelo as Modelo;

class ComboBoxCurso {

    public static function montarTodosOsTipos() {
        $codigo = "";
        $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
        $cursoDAO = new Modelo\cursoDAO();
        for ($i = 1; $i <= TipoCurso::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $cursoDAO->obterNomeTipoCurso($i) . "</option>";
        }
        return $codigo;
    }

    public static function montarTodosOsCursos($tipo = null) {
        $codigo = "";
        $cursos = (new Modelo\cursoDAO())->consultar();
        if (sizeof($cursos) == 0) {
            $codigo .= '<option value="default" selected="selected"> -- Não existem cursos cadastrados --</option>';
        } else {
            if (!$tipo) {
                $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
            } else {
                $codigo .= '<option value="default" selected="selected"> Selecionado: ' . $tipo . ' </option>';
            }
            for ($i = 0; $i < sizeof($cursos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($cursos[$i]['idCurso']) . "\">" . $cursos[$i]['nomeCurso'] . "</option>";
            }
        }
        $codigo .= "</select>";
        return $codigo;
    }

}

?>
