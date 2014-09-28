<?php

namespace app\modelo;

include_once APP_DIR . 'modelo/vo/Usuario.php';
include_once APP_DIR . 'modelo/dao/usuarioDAO.php';
include_once APP_DIR . 'modelo/dao/areaDAO.php';
require_once 'enumeracao/ImagensDificuldadeEnum.php';
require_once 'enumeracao/Ferramenta.php';
require_once 'enumeracao/Area.php';
require_once 'enumeracao/TipoCurso.php';
require_once 'enumeracao/Papel.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/Permissao.php';

class Menu {

    private $menus = [];

    private function __construct() {

        $this->menus[Ferramenta::CONTROLE_USUARIOS] = [
            ['usuarios', "Usuários"]
            , Permissao::ADMINISTRADOR => array(
                ["#!usuarios|restaurar", "Usuários inativos"]
            )
            , Permissao::GESTOR => array(
                ["#!usuarios|gerenciar", "Gerenciar usuários"]
            )
            , Permissao::ESCRITA => array(
                ["#!usuarios|novo", "Novo usuário"]
            )
            , Permissao::CONSULTA => array(
                ["#!usuarios|consultar", "Consultar usuários"]
            )
        ];

        $this->menus[Ferramenta::CURSOS_E_POLOS] = [
            ['cursospolos', "Cursos e polos"]
            , Permissao::ADMINISTRADOR => array()
            , Permissao::GESTOR => array(
                ["#!cursospolos|gerenciarcursos", "Gerenciar cursos"],
                ["#!cursospolos|gerenciarpolos", "Gerenciar polos"]
            )
            , Permissao::ESCRITA => array(
                ["#!cursospolos|novocurso", "Novo curso"],
                ["#!cursospolos|novopolo", "Novo polo"]
            )
            , Permissao::CONSULTA => array()
        ];

        $this->menus[Ferramenta::CONTROLE_LIVROS] = [
            ['livros', "Livros"]
            , Permissao::ADMINISTRADOR => array(
                ["#!livros|gerenciarbaixasesaidas", "Administrar baixas e saídas"]
            )
            , Permissao::GESTOR => array(
                ["#!livros|gerenciar", "Gerenciar livros"],
                ["#!livros|saida", "Registrar saída"]
            )
            , Permissao::ESCRITA => array(
                ["#!livros|retorno", "Registrar retorno"],
                ["#!livros|novo", "Cadastrar livro"]
            )
            , Permissao::CONSULTA => array(
                ["#!livros|consultar", "Consultar livros"],
                ["#!livros|relatorios", "Gerar relatórios"]
            )
        ];

        $this->menus[Ferramenta::CONTROLE_EQUIPAMENTOS] = [
            ['equipamentos', "Equipamentos"]
            , Permissao::ADMINISTRADOR => array(
                ["#!equipamentos|gerenciarbaixasesaidas", "Administrar baixas e saídas"]
            )
            , Permissao::GESTOR => array(
                ["#!equipamentos|gerenciar", "Gerenciar equipamentos"],
                ["#!equipamentos|saida", "Registrar saída"]
            )
            , Permissao::ESCRITA => array(
                ["#!equipamentos|retorno", "Registrar retorno"],
                ["#!equipamentos|novo", "Cadastrar equipamento"]
            )
            , Permissao::CONSULTA => array(
                ["#!equipamentos|consultar", "Consultar equipamentos"]
            )
        ];

        $this->menus[Ferramenta::CONTROLE_DOCUMENTOS] = [
            ['documentos', "Documentos"]
            , Permissao::ADMINISTRADOR => array()
            , Permissao::GESTOR => array(
                ["#!documentos|gerenciar", "Gerenciar histórico"],
                ["#!documentos|gerenciarCabecalho", "Gerenciar Cabeçalho"]
            )
            , Permissao::ESCRITA => array(
                ["#!documentos|oficio", "Criar ofício"],
                ["#!documentos|memorando", "Criar memorando"]
            )
            , Permissao::CONSULTA => array(
                ["#!documentos|consultar", "Consultar histórico"]
            )
        ];

        $this->menus[Ferramenta::CONTROLE_VIAGENS] = [
            ['viagens', "Viagens"]
            , Permissao::ADMINISTRADOR => array()
            , Permissao::GESTOR => array(
                ["#!viagens|gerenciar", "Gerenciar viagens"]
            )
            , Permissao::ESCRITA => array(
                ["#!viagens|nova", "Inserir nova viagem"],
            )
            , Permissao::CONSULTA => array()
        ];

        $this->menus[Ferramenta::TAREFAS] = [
            ['tarefas', "Tarefas"]
            , Permissao::ADMINISTRADOR => array()
            , Permissao::GESTOR => array(
                ["#!tarefas|gerenciar", "Gerenciar tarefas"]
            )
            , Permissao::ESCRITA => array(
                ["#!tarefas|nova", "Nova Tarefa"],
            )
            , Permissao::CONSULTA => array()
        ];


        $this->menus[Ferramenta::GALERIA_IMAGENS] = [
            ['imagens', "Imagens"]
            , Permissao::ADMINISTRADOR => array()
            , Permissao::GESTOR => array(
                ["#!imagens|gerenciarDescritores", "Gerenciar descritores"],
                ["#!imagens|novoDescritor", "Novo descritor"]
            )
            , Permissao::ESCRITA => array(
                ["#!imagens|novaImagem", "Cadastrar imagem"]
            )
            , Permissao::CONSULTA => array(
                ["#!imagens|consultarimagem", "Consultar imagens"]
            )
        ];

//        $this->menus[Ferramenta::PROCESSOS] = [
////            ['processos', "Processos"]
////            , Permissao::ADMINISTRADOR => array()
////            , Permissao::GESTOR => array()
////            , Permissao::ESCRITA => array()
////            , Permissao::CONSULTA => array()
//        ];
    }

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

        $Menu = new Menu();
        foreach (Ferramenta::obterValores() as $ferramenta) {
            $permissao = $permissoes_indice_ferramentas[$ferramenta];

            if (!isset($Menu->menus[$ferramenta])) {
                continue;
            } else {
                $codigo = static::_processarDados($Menu->menus[$ferramenta], $permissao);
            }
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