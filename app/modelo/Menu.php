<?php

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

    public static function montarMenuNavegacao() {

        $permissoes = (new usuarioDAO())->obterPermissoes(obterUsuarioSessao()->get_idUsuario());

        $menuCode = "<div class=\"menu\">" . "\n";
        $menuCode .= "<menu class=\"centralizado\">" . "\n";
        $menuCode .= "<a href=\"#!inicial|homepage\"><li class=\"menuLink actualTool visited\" id=\"homeLink\" class=\"visited\">Home</li></a>" . "\n";

        $subMenuCode = "<div class=\"subMenu\">" . "\n";
        $subMenuCode .= "<menu>" . "\n";

        foreach ($permissoes as $permissao_ferramenta) :

            switch ($permissao_ferramenta['idFerramenta']) :
                case Ferramenta::CONTROLE_USUARIOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"usuariosLink\">Usuários</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink usuariosSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                                $subMenuCode .= '<a href="#!usuarios|restaurar" class="linkAdministrativo">' . "\n";
                                $subMenuCode .= "<li>Usuários inativos</li></a>" . "\n";
                            case Permissao::GESTOR:
                                $subMenuCode .= "   <a href=\"#!usuarios|gerenciar\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar usuários</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "   <a href=\"#!usuarios|novo\">" . "\n";
                                $subMenuCode .= "<li>Novo usuário</li></a>" . "\n";
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
                                $subMenuCode .= "<li>Cadastrar curso</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!cursospolos|novopolo\"\">" . "\n";
                                $subMenuCode .= "<li>Cadastrar polo</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
                    }
                    break;
                case Ferramenta::CONTROLE_LIVROS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"livrosLink\">Livros</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink livrosSubMenu\">" . "\n";
                        $permissao = $permissao_ferramenta['idPermissao'];
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                                $subMenuCode .= '<a href="#!livros|gerenciarbaixasesaidas" class="linkAdministrativo">' . "\n";
                                $subMenuCode .= "<li>Administrar baixas e saídas</li></a>" . "\n";
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!livros|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar livros</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!livros|retorno\"\">" . "\n";
                                $subMenuCode .= "<li>Registrar retorno</li></a>" . "\n";
                                if ($permissao == Permissao::GESTOR) {
                                    $subMenuCode .= "<a href=\"#!livros|saida\"\">" . "\n";
                                    $subMenuCode .= "<li>Registrar saída</li></a>" . "\n";
                                }
                                $subMenuCode .= '<a href="#!livros|novo">';
                                $subMenuCode .= "<li>Cadastrar livro</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!livros|consultar\"\">" . "\n";
                                $subMenuCode .= "<li>Consultar livros</li></a>" . "\n";
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
                                $subMenuCode .= '<a href="#!equipamentos|gerenciarbaixasesaidas" class="linkAdministrativo">' . "\n";
                                $subMenuCode .= "<li>Administrar baixas e saídas</li></a>" . "\n";
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
                                $subMenuCode .= "<li>Novo equipamento</li></a>" . "\n";
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
                                $subMenuCode .= "<a href=\"#!documentos|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar histórico</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!documentos|gerenciarCabecalho\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar Cabeçalho</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!documentos|gerarOficio\"\">" . "\n";
                                $subMenuCode .= "<li>Gerar ofício</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!documentos|gerarMemorando\"\">" . "\n";
                                $subMenuCode .= "<li>Gerar memorando</li></a>" . "\n";
//                                $subMenuCode .= "<a href=\"javascript:void(0)\" onclick=\"ajax('index.php?c=documentos&a=gerarRelatorio')\">" . "\n";
//                                $subMenuCode .= "<li>Gerar relatório</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!documentos|consultar\"\">" . "\n";
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
                case Ferramenta::TAREFAS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"tarefasLink\">Tarefas</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink tarefasSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!tarefas|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar Tarefas</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!tarefas|nova\"\">" . "\n";
                                $subMenuCode .= "<li>Nova Tarefa</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
                    }
                    break;
//                case Ferramenta::CONTROLE_PAGAMENTOS:
//                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
//                        $menuCode .= "<a><li class=\"menuLink\" id=\"pagamentosLink\">Pagamentos</li></a>" . "\n";;
//                        $subMenuCode .="<ul class=\"hiddenSubMenuLink pagamentosSubMenu\">" . "\n";
//                        switch ($permissao_ferramenta['idPermissao']) {
//                            case Permissao::ADMINISTRADOR:
//                            case Permissao::GESTOR:
//                                $subMenuCode .= "<a href=\"#!pagamentos|gerenciar\"\">" . "\n";
//                                $subMenuCode .= "<li>Gerenciar Pagamentos</li></a>" . "\n";
//                            case Permissao::ESCRITA:
//                                $subMenuCode .= "<a href=\"#!pagamentos|nova\"\">" . "\n";
//                                $subMenuCode .= "<li>Nova Ordem de Pagamento</li></a>" . "\n";
//                            case Permissao::CONSULTA:
//                                $subMenuCode .= "<a href=\"#!pagamentos|consultar\"\">" . "\n";
//                                $subMenuCode .= "<li>Verificar Pagamentos</li></a>" . "\n";
//                        }
//                    }
//                    break;
                case Ferramenta::GALERIA_IMAGENS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"imagensLink\">Imagens</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink imagensSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!imagens|gerenciarDescritores\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar Descritores</li></a>" . "\n";
                                $subMenuCode .= "<a href=\"#!imagens|novoDescritor\"\">" . "\n";
                                $subMenuCode .= "<li>Novo Descritor</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!imagens|novaImagem\"\">" . "\n";
                                $subMenuCode .= "<li>Cadastrar Imagem</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!imagens|consultarimagem\"\">" . "\n";
                                $subMenuCode .= "<li>Consultar Imagens</li></a>" . "\n";
                        }
                    }
                    break;
                    case Ferramenta::PROCESSOS:
                    if ($permissao_ferramenta['idPermissao'] != Permissao::SEM_ACESSO) {
                        $menuCode .= "<a><li class=\"menuLink\" id=\"tarefasLink\">Tarefas</li></a>" . "\n";
                        $subMenuCode .="<ul class=\"hiddenSubMenuLink tarefasSubMenu\">" . "\n";
                        switch ($permissao_ferramenta['idPermissao']) {
                            case Permissao::ADMINISTRADOR:
                            case Permissao::GESTOR:
                                $subMenuCode .= "<a href=\"#!tarefas|gerenciar\"\">" . "\n";
                                $subMenuCode .= "<li>Gerenciar Tarefas</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!tarefas|nova\"\">" . "\n";
                                $subMenuCode .= "<li>Nova Tarefa</li></a>" . "\n";
                            case Permissao::CONSULTA:
                        }
                    }
                    break;
            endswitch;
//            $subMenuCode .= '<a class="hideSubMenu" onclick="hideSubMenu();">'
//                    . '<li class="visited">'
//                    . '<img alt="Esconder sub-menu" src="publico/imagens/icones/go-up.png" />'
//                    . '</li>'
//                    . '</a>';
            $subMenuCode .= "</ul>";
        endforeach;

        $menuCode .= "</menu>" . "\n";
        $menuCode .= "</div>" . "\n";

        $subMenuCode .= "</menu>" . "\n";
        $subMenuCode .= "</div>" . "\n";

        return $menuCode . $subMenuCode;
    }

}
