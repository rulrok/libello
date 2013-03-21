<?php

include_once __DIR__ . '/../../app/modelo/vo/Usuario.php';
include_once __DIR__ . '/../../app/modelo/dao/usuarioDAO.php';
require_once 'Ferramenta.php';
require_once 'Permissoes.php';

class Menu {

    public static function montarMenu() {

        $usuario = new Usuario();
        $usuario->set_id($_SESSION['idUsuario']);
        $permissoes = usuarioDAO::obterPermissoes($usuario);

        $menuCode = "<div class=\"menu\">" . "\n";
        $menuCode .= "<menu class=\"centered\">" . "\n";

        $subMenuCode = "<div class=\"subMenu\">" . "\n";
        $subMenuCode .= "<menu>" . "\n";

        foreach ($permissoes as $permissao_ferramenta) {

            switch ($permissao_ferramenta['idFerramenta']) {
                case Ferramenta::CONTROLE_USUARIOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"usuariosLink\">Controle de usuarios</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink usuariosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "   <a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar usuários</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo usuário</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=usuario&a=consultar')\">" . "\n";
                                $subMenuCode .= "<li>Consultar usuários</li></a>" . "\n";
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CURSOS_E_POLOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"cursosLink\">Cursos e polos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink cursosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursos&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar registros</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=cursos&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo registro</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_LIVROS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"livrosLink\">Livros</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink livrosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar livros</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=saida')\">" . "\n";
                                $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=retorno')\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Inserir novo registro</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=livro&a=relatorios')\">" . "\n";
                                $subMenuCode .= "<li>Gerar relatórios</li></a>" . "\n";
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_EQUIPAMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"equipamentosLink\">Equipamentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink equipamentosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar equipamentos</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=saida')\">" . "\n";
                                $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=retorno')\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=novo')\">" . "\n";
                                $subMenuCode .= "<li>Registrar novo equipamento</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=equipamento&a=consulta')\">" . "\n";
                                $subMenuCode .= "<li>Consultar equipamentos</li></a>" . "\n";
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_DOCUMENTOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"documentosLink\">Documentos</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink documentosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=historico')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar histórico</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarOficio')\">" . "\n";
                                $subMenuCode .= "<li>Gerar ofício</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarRelatorio')\">" . "\n";
                                $subMenuCode .= "<li>Gerar relatório</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
                case Ferramenta::CONTROLE_VIAGENS:
                    if ($permissao_ferramenta['idPermissao'] != Permissoes::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"viagensLink\">Viagens</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink viagensSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissoes::ADMINISTRADOR:
                            case Permissoes::GESTOR:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=viagens&a=gerenciar')\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar viagens</li></a>" . "\n";
                            case Permissoes::ESCRITA:
                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=viagens&a=nova')\">" . "\n";
                                $subMenuCode .= "<li>Inserir nova viagem</li></a>" . "\n";
                            case Permissoes::CONSULTA:
                        }
                        $subMenuCode .= "<a id=\"hideSubMenu\" onclick=\"hideSubMenu();\"><li class=\"visited\"><img alt=\"Esconder sub-menu\" src=\"publico/images/icons/go-up.png\"></li></a>" . "\n";
                        $subMenuCode .= "</ul>" . "\n";
                    }
                    break;
            }
        }

        $menuCode .= "</menu>" . "\n";
        $menuCode .= "</div>" . "\n";



        $subMenuCode .= "</menu>" . "\n";
        $subMenuCode .= "</div>" . "\n";

        return $menuCode . $subMenuCode;
    }

}
?>

