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
        $menuCode .= "<a onclick=\"ajax('index.php?c=inicial&a=homepage');\"><li class=\"menuLink visited\" id=\"homeLink\" class=\"visited\">Home</li></a>" . "\n";

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
                                $subMenuCode .= "   <a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=restaurar')\">" . "\n";
                                $subMenuCode .= "<li>Verificar usuários excluídos</li></a>" . "\n";
                            case Permissao::GESTOR:
                                $subMenuCode .= "   <a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar usuários</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo usuário</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=consultar')\">" . "\n";
                                $subMenuCode .= "<li>Consultar usuários</li></a>" . "\n";
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CURSOS_E_POLOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"cursosLink\">Cursos e polos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink cursosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursospolos&a=gerenciarcursos')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar cursos</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursospolos&a=gerenciarpolos')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar polos</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursospolos&a=novocurso')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo curso</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursospolos&a=novopolo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo polo</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_LIVROS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"livrosLink\">Livros</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink livrosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar livros</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=saida')\">" . "\n";
                                $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=retorno')\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo registro</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=relatorios')\">" . "\n";
                                $subMenuCode .= "<li>Gerar relatórios</li></a>" . "\n";
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_EQUIPAMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"equipamentosLink\">Equipamentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink equipamentosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar equipamentos</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=saida')\">" . "\n";
                                $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=retorno')\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Registrar novo equipamento</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=consultar')\">" . "\n";
                                $subMenuCode .= "<li>Consultar equipamentos</li></a>" . "\n";
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_DOCUMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"documentosLink\">Documentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink documentosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=historico')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar histórico</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarOficio')\">" . "\n";
                                $subMenuCode .= "<li>Gerar ofício</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarMemorando')\">" . "\n";
                                $subMenuCode .= "<li>Gerar memorando</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarRelatorio')\">" . "\n";
                                $subMenuCode .= "<li>Gerar relatório</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_VIAGENS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"viagensLink\">Viagens</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink viagensSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=viagens&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar viagens</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=viagens&a=nova')\">" . "\n";
                                $subMenuCode .= "<li>Inserir nova viagem</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
//                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/imagens/icones/go-up.png\"></li></a>" . "\n";
//                        $subMenuCode .= "</ul>" . "\n";
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
    
    public static function montarCaixaSelecaoAreas($required = false, $class = null, $name = null){
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
    
    public static function montarCaixaSelecaoTiposCurso($required = false, $class = null, $name = null){
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
        for ($i = 1; $i <= TipoCurso::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . cursoDAO::obterNomeTipoCurso($i) . "</option>\n";
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

}
?>

