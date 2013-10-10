<?php

include_once ROOT . 'app/modelo/vo/Usuario.php';
include_once ROOT . 'app/modelo/dao/usuarioDAO.php';
include_once ROOT . 'app/modelo/dao/areaDAO.php';
require_once 'enumeracao/Ferramenta.php';
require_once 'enumeracao/Area.php';
require_once 'enumeracao/TipoCurso.php';
require_once 'enumeracao/Papel.php';
require_once BIBLIOTECA_DIR . 'seguranca/Permissao.php';

class Menu {

    public static function montarMenuNavegacao() {

        $permissoes = usuarioDAO::obterPermissoes($_SESSION['usuario']->get_id());

        $menuCode = "<div class=\"menu\">" . "\n";
        $menuCode .= "<menu class=\"centered\">" . "\n";
        $menuCode .= "<a href=\"#!inicial|homepage\"><li class=\"menuLink actualTool visited\" id=\"homeLink\" class=\"visited\">Home</li></a>" . "\n";

        $subMenuCode = "<div class=\"subMenu\">" . "\n";
        $subMenuCode .= "<menu>" . "\n";

        foreach ($permissoes as $permissao_ferramenta) {

            switch ($permissao_ferramenta['idFerramenta']) {
                case Ferramenta::CONTROLE_USUARIOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"usuariosLink\">Usuários</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink usuariosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
//                                $subMenuCode .= "   <a href=\"#!usuarios|restaurar\">" . "\n";
//                                $subMenuCode .= "<li>Verificar usuários excluídos</li></a>" . "\n";
                            case Permissao::GESTOR:
                                $subMenuCode .= "   <a href=\"#!usuarios|gerenciar\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar usuários</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "   <a href=\"#!usuarios|novo\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo usuário</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "   <a href=\"#!usuarios|consultar\">" . "\n";
                                $subMenuCode .= "<li>Consultar usuários</li></a>" . "\n";
                        }
                    }
                    break;
                case Ferramenta::CURSOS_E_POLOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"cursospolosLink\">Cursos e polos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink cursospolosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!cursospolos|gerenciarcursos\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar cursos</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!cursospolos|gerenciarpolos\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar polos</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!cursospolos|novocurso\"\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo curso</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!cursospolos|novopolo\"\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo polo</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
                    }
                    break;
                case Ferramenta::CONTROLE_LIVROS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"livrosLink\">Livros</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink livrosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!livros|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar livros</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!livros|saida\"\">" . "\n";
                                $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!livros|retorno\"\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= '<a href="#!livros|novo">';
                                $subMenuCode .= "<li>Inserir novo registro</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!livros|relatorios\"\">" . "\n";
                                $subMenuCode .= "<li>Gerar relatórios</li></a>" . "\n";
                        }
                    }
                    break;
                case Ferramenta::CONTROLE_EQUIPAMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"equipamentosLink\">Equipamentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink equipamentosSubMenu\">" . "\n";
                        $permissao = $permissao_ferramenta['idPermissao'];
                        switch ($permissao) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!equipamentos|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar equipamentos</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                if ($permissao === Permissao::GESTOR) {
                                    $subMenuCode .= "<a href=\"#!equipamentos|saida\"\">" . "\n";
                                    $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                }
                                $subMenuCode .= "<a href=\"#!equipamentos|retorno\"\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!equipamentos|novo\"\">" . "\n";
                                $subMenuCode .= "<li>Registrar novo equipamento</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!equipamentos|consultar\"\">" . "\n";
                                $subMenuCode .= "<li>Consultar equipamentos</li></a>" . "\n";
                        }
                    }
                    break;
                case Ferramenta::CONTROLE_DOCUMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"documentosLink\">Documentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink documentosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar histórico</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!documentos|gerarOficio\"\">" . "\n";
                                $subMenuCode .= "<li>Gerar ofício</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!documentos|gerarMemorando\"\">" . "\n";
                                $subMenuCode .= "<li>Gerar memorando</li></a>" . "\n";
//                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarRelatorio')\">" . "\n";
//                                $subMenuCode .= "<li>Gerar relatório</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=consultar')\">" . "\n";
                                $subMenuCode .= "<li>Consultar histórico</li></a>" . "\n";
                        }
                    }
                    break;
                case Ferramenta::CONTROLE_VIAGENS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"viagensLink\">Viagens</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink viagensSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!viagens|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar viagens</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!viagens|nova\"\">" . "\n";
                                $subMenuCode .= "<li>Inserir nova viagem</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
                    }
                    break;
            }
//            $subMenuCode .= "<a class =\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
            $subMenuCode .= "</ul>" . "\n";
        }


        $menuCode .= "</menu>" . "\n";
        $menuCode .= "</div>" . "\n";



        $subMenuCode .= "</menu>" . "\n";
        $subMenuCode .= "</div>" . "\n";

        return $menuCode . $subMenuCode;
    }

    public static function montarCaixaSelecaoPermissoes($required = null, $class = null, $name = null) {
        if ($required === true) {
            if ($class == null) {
                $class = "";
            }
        }
        $codigo = "<select " . ($required === true ? "required " : " ") . ($class !== null ? "class=\"" . $class . "\"" : " ") . ($name !== null ? "name =\"" . $name . "\"" : " ") . ">";
        $codigo .= "\n<option value=\"default\"> -- Selecione uma opção -- </option>";
        $codigo .= "\n<option value=\"1\">Sem acesso</option>";
        $codigo .= "\n<option value=\"2\">Consulta</option>";
        $codigo .= "\n<option value=\"3\">Escrita</option>";
        $codigo .= "\n<option value=\"4\">Gestor</option>";
        $codigo .= "\n<option value=\"5\">Administrador</option>";
        $codigo .= "</select>";
        return $codigo;
    }

    public static function montarCaixaSelecaoPapeis($required = false, $class = null, $name = null) {
        $codigo = "<select ";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= ">\n";

        $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
        for ($i = 1; $i <= Papel::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . papelDAO::obterNomePapel($i) . "</option>\n";
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoAreas($required = false, $class = null, $name = null) {
        $codigo = "<select ";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= ">\n";

        $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
        for ($i = 1; $i <= Area::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . areaDAO::obterNomeArea($i) . "</option>\n";
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoTiposCurso($required = false, $class = null, $id = null, $name = null) {
        $codigo = "<select ";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($id != null) {
            $codigo .= " id = \"" . $id . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= ">\n";

        $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
        for ($i = 1; $i <= TipoCurso::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . cursoDAO::obterNomeTipoCurso($i) . "</option>\n";
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoCursos($required = false, $class = null, $id = null, $name = null) {
        $codigo = "<select ";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($id != null) {
            $codigo .= " id = \"" . $id . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= ">\n";

        $cursos = cursoDAO::consultar();
        if (sizeof($cursos) == 0) {
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem cursos cadastrados --</option>\n";
        } else {
            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
            for ($i = 0; $i < sizeof($cursos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($cursos[$i]['idCurso']) . "\">" . $cursos[$i]['nome'] . "</option>\n";
            }
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoPolos($required = false, $class = null,$id = null, $name = null) {
        $codigo = "<select ";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($id != null) {
            $codigo .= " id = \"" . $id . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= ">\n";

        $polos = poloDAO::consultar();
        if (sizeof($polos) == 0) {
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem polos cadastrados --</option>\n";
        } else {
            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
            for ($i = 0; $i < sizeof($polos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($polos[$i]['idPolo']) . "\">" . $polos[$i]['nome'] . "</option>\n";
            }
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarSelecaoPassageiros($required = false, $class = null, $id = null, $name = null) {
        $codigo = "<select multiple='multiple' size='7'";
        if ($required) {
            $codigo .= "required ";
        }
        if ($class != null) {
            $codigo .= " class = \"" . $class . "\" ";
        }
        if ($id != null) {
            $codigo .= " id = \"" . $id . "\" ";
        }
        if ($name != null) {
            $codigo .= " name = \"" . $name . "\"";
        }
        $codigo .= " style='display: table-cell;'>\n";
        for ($i = 1; $i <= Papel::__length; $i++) {
            $usuarios = usuarioDAO::consultar("idUsuario,concat(PNome,' ',UNome) as Nome,email", "idPapel = " . $i);
            if (sizeof($usuarios) == 0) {
                continue;
            } else {
                $nomePapel = papelDAO::obterNomePapel($i);
//            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
                $codigo .= "<optgroup label='$nomePapel'>\n";
                for ($j = 0; $j < sizeof($usuarios); $j++) {
                    $codigo .= "<option value=\"" . fnEncrypt($usuarios[$j]['idUsuario']) . "\">" . $usuarios[$j]['Nome'] . " (" . $usuarios[$j]['email'] . ")</option>\n";
                }
                $codigo .= "</optgroup>\n";
            }
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

}
?>

