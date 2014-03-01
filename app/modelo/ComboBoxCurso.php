<?php

require BIBLIOTECA_DIR . "configuracoes.php";
require_once "Menu.php";

class ComboBoxCurso {

    public static function montarTodosOsTipos() {
        $codigo = "";
        $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
        $cursoDAO = new cursoDAO();
        for ($i = 1; $i <= TipoCurso::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $cursoDAO->obterNomeTipoCurso($i) . "</option>";
        }
        return $codigo;
    }

    public static function montarTodosOsCursos() {
        $codigo = "";
        $cursos = (new cursoDAO())->consultar();
        if (sizeof($cursos) == 0) {
            $codigo .= '<option value="default" selected="selected"> -- Não existem cursos cadastrados --</option>';
        } else {
            $codigo .= '<option value="default" selected="selected"> -- Selecione uma opção --</option>';
            for ($i = 0; $i < sizeof($cursos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($cursos[$i]['idCurso']) . "\">" . $cursos[$i]['nomeCurso'] . "</option>";
            }
        }
        $codigo .= "</select>";
        return $codigo;
    }

}

?>
