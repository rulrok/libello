<?php

namespace app\modelo;

require_once 'enumeracao/Ferramenta.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/Permissao.php';

class Menu {

    private static function _processarDados($menu, $permissao) {

        if ($permissao == Permissao::SEM_ACESSO || empty($menu)) {
            return ['', "\n\t<ul>\n"];
        }

        $id = $menu[0][0] . "Link";
        $subClass = $menu[0][0] . "SubMenu";
        $nomeMenu = $menu[0][1];

        $menuCode = "<a><li class='menuLink' id='$id'>$nomeMenu</li></a>" . "\n";

        $subMenuCode = "\n\t<ul class='hiddenSubMenuLink $subClass'>" . "\n";

        switch ($permissao) {
            case Permissao::ADMINISTRADOR:
                foreach ($menu[Permissao::ADMINISTRADOR] as $submenu) {
                    $link = $submenu[0];
                    $nome = $submenu[1];
                    $subMenuCode .= "\t\t<a href='$link' class='linkAdministrativo'>" . "\n";
                    $subMenuCode .= "\t\t<li>$nome</li></a>" . "\n";
                }
            case Permissao::GESTOR:
                foreach ($menu[Permissao::GESTOR] as $submenu) {
                    $link = $submenu[0];
                    $nome = $submenu[1];
                    $subMenuCode .= "\t\t<a href='$link'>" . "\n";
                    $subMenuCode .= "\t\t<li>$nome</li></a>" . "\n";
                }
            case Permissao::ESCRITA:
                foreach ($menu[Permissao::ESCRITA] as $submenu) {
                    $link = $submenu[0];
                    $nome = $submenu[1];
                    $subMenuCode .= "\t\t<a href='$link'>" . "\n";
                    $subMenuCode .= "\t\t<li>$nome</li></a>" . "\n";
                }
            case Permissao::CONSULTA:
                foreach ($menu[Permissao::CONSULTA] as $submenu) {
                    $link = $submenu[0];
                    $nome = $submenu[1];
                    $subMenuCode .= "\t\t<a href='$link'>" . "\n";
                    $subMenuCode .= "\t\t<li>$nome</li></a>" . "\n";
                }
        }

        return [$menuCode, $subMenuCode];
    }

    private static function _montarDados($menu, $submenu) {
        $menuInfos = array();

        if (is_null($menu) || empty($menu)) {
            return $menuInfos;
        }
        $menuInfos[0] = [$menu['idLink'], $menu['nomeMenu']];
        $permissoes = Permissao::obterValores();
        foreach ($permissoes as $permissao) {
            $menuInfos[$permissao] = [];
        }
        foreach ($submenu as $sublink) {
            $i = $sublink['nivelPermissao'];
            $valores = [$sublink['link'], $sublink['nomeSubmenu']];
            $menuInfos[$i][] = $valores;
        }
        return $menuInfos;
    }

    public static function montarMenuNavegacao() {


        $permissoes = (new usuarioDAO())->obterPermissoes(obterUsuarioSessao()->get_idUsuario());

        $permissoes_indice_ferramentas = array();

        for ($i = 0; $i < count($permissoes); $i++) {
            $permissoes_indice_ferramentas[$permissoes[$i][0]] = $permissoes[$i][1];
        }

        $menuCode = "<div class=\"menu\">\n";
        $menuCode .= "\t<menu class=\"centralizado\">\n";
        $menuCode .= "\t\t<a href=\"#!inicial|homepage\"><li class=\"menuLink actualTool visited\" id=\"homeLink\" class=\"visited\">Home</li></a>" . "\n";

        $subMenuCode = "<div class=\"subMenu\">" . "\n";
        $subMenuCode .= "<menu>" . "\n";

        $sistemaDAO = new sistemaDAO();

        foreach (Ferramenta::obterValores() as $ferramenta) {
            $permissao = $permissoes_indice_ferramentas[$ferramenta];

            $menu = $sistemaDAO->recuperarMenu($ferramenta);
            //Se não existe um menu cadastrado para alguma ferramenta, o resultado será um veto vazio,
            //obviamente se não há um menu, não há submenus e apenas pulamos essa etapa
            if (empty($menu)) {
                continue;
            }
            $submenu = $sistemaDAO->recuperarSubmenu($ferramenta);
            $menuInfos = static::_montarDados($menu[0], $submenu);

            $codigo = static::_processarDados($menuInfos, $permissao);

            $menuCode .= "\t\t" . $codigo[0];
            $subMenuCode .= "\t" . $codigo[1];
            $subMenuCode .= "\t</ul>";
        }

        $menuCode .= "\n\t</menu>" . "\n";
        $menuCode .= "</div>" . "\n";

        $subMenuCode .= "\n</menu>" . "\n";
        $subMenuCode .= "</div>" . "\n";

        return $menuCode . $subMenuCode;
    }

}

?>