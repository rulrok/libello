<?php

include_once APP_LOCATION . 'modelo/vo/Usuario.php';
include_once APP_LOCATION . 'modelo/dao/usuarioDAO.php';
include_once APP_LOCATION . 'modelo/dao/areaDAO.php';
require_once 'enumeracao/ImagensDificuldadeEnum.php';
require_once 'enumeracao/Ferramenta.php';
require_once 'enumeracao/Area.php';
require_once 'enumeracao/TipoCurso.php';
require_once 'enumeracao/Papel.php';
require_once BIBLIOTECA_DIR . 'seguranca/Permissao.php';

class Menu {

    public static function montarMenuNavegacao() {

        $permissoes = (new usuarioDAO())->obterPermissoes(obterUsuarioSessao()->get_idUsuario());

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
                                $subMenuCode .= "<a href=\"#!usuarios|restaurar\" style=\"color: red;\"\">" . "\n";
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
                                $subMenuCode .= "<a href=\"#!livros|gerenciarbaixasesaidas\" style=\"color: red;\"\">" . "\n";
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
                                $subMenuCode .= "<a href=\"#!equipamentos|gerenciarbaixasesaidas\" style=\"color: red;\"\">" . "\n";
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
//                        $menuCode .= "<a><li class=\"menuLink\" id=\"pagamentosLink\">Pagamentos</li></a>" . "\n";
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
                                $subMenuCode .= "<a href=\"#!imagens|descritores\"\">" . "\n";
                                $subMenuCode .= "<li>Descritores</li></a>" . "\n";
//                                $subMenuCode .= "<a href=\"#!imagens|gerenciarGalerias\"\">" . "\n";
//                                $subMenuCode .= "<li>Gerenciar Galerias</li></a>" . "\n";
                            case Permissao::ESCRITA:
                                $subMenuCode .= "<a href=\"#!imagens|novaImagem\"\">" . "\n";
                                $subMenuCode .= "<li>Cadastrar imagem</li></a>" . "\n";
                            case Permissao::CONSULTA:
                                $subMenuCode .= "<a href=\"#!imagens|consultar\"\">" . "\n";
                                $subMenuCode .= "<li>Consultar galerias</li></a>" . "\n";
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
        $codigo .= "\n<option value=\"10\">Consulta</option>";
        $codigo .= "\n<option value=\"20\">Escrita</option>";
        $codigo .= "\n<option value=\"30\">Gestor</option>";
        $codigo .= "\n<option value=\"40\">Administrador</option>";
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
        $DAO = new papelDAO();
        for ($i = 1; $i <= Papel::__length; $i++) {
            $codigo .= "<option value=\"$i\">" . $DAO->obterNomePapel($i) . "</option>\n";
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoAreas($required = false, $class = null, $id = null, $name = null) {
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
                $codigo .= "<option value=\"" . fnEncrypt($cursos[$i]['idCurso']) . "\">" . $cursos[$i]['nomeCurso'] . "</option>\n";
            }
        }
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoPolos($required = false, $class = null, $id = null, $name = null) {
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
            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione um descritor --</option>\n";
            $codigo .= "<optgroup label='Polos'>\n";
            for ($i = 0; $i < sizeof($polos); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($polos[$i]['idPolo']) . "\">" . $polos[$i]['nomePolo'] . "</option>\n";
            }
        }
        $codigo .= "</optgroup>\n";
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarCaixaSelecaoDescritorFilho($nivel, $required = false, $class = null, $id = null, $name = null, $idCategoriaPai = null) {
        if ($idCategoriaPai != null) {
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
            $codigo .= " numero='$nivel'>\n";

            $subcategorias = imagensDAO::consultarDescritoresFilhos("*", "pai = $idCategoriaPai");
            if (sizeof($subcategorias) == 0) {
                $caminho = imagensDAO::consultarCaminhoDescritores($idCategoriaPai);
                $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
                $codigo .= "</select>\n";
                $body = "Usuário: " . obterUsuarioSessao()->get_PNome() . " " . obterUsuarioSessao()->get_UNome() . " (" . obterUsuarioSessao()->get_email() . ")%0D%0A";
                $body .= "Desejo cadastrar o descritor de nome <nome_do_descritor> em $caminho";
                $codigo .="<a style=\"display: inline-block;\" target=\"_blank\" href=\"mailto:bei-bi@inep.gov.br?subject=Cadastro de descritor&body=$body\">Solicitar cadastro de novo descritor</a>";
            } else {
                $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione um descritor --</option>\n";
//                $codigo .= "<optgroup label='Subcategorias'>\n";
                for ($i = 0; $i < sizeof($subcategorias); $i++) {
                    $codigo .= "<option value=\"" . fnEncrypt($subcategorias[$i]['idDescritor']) . "\">" . $subcategorias[$i]['nome'] . "</option>\n";
                }
//            $codigo .= "</optgroup>\n";
                $codigo .= "</select>\n";
            }
            return $codigo;
        } else {
            return "<p>Descritor pai não informado.</p>";
        }
    }

    public static function montarCaixaSelecaoDescritorPrimeiroNivel($required = false, $class = null, $id = null, $name = null) {
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
        $codigo .= " numero='1'>\n";

        $categorias = imagensDAO::consultarDescritoresPais();
        if (sizeof($categorias) == 0) {
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem descritores cadastrados --</option>\n";
            $codigo .= "</select>\n";
            $body = "Usuário: " . obterUsuarioSessao()->get_PNome() . " " . obterUsuarioSessao()->get_UNome() . " (" . obterUsuarioSessao()->get_email() . ")%0D%0A";
            $body .= "Desejo cadastrar o descritor de nome <nome_do_descritor> em $caminho";
            $codigo .="<a style=\"display: inline-block;\" target=\"_blank\" href=\"mailto:bei-bi@inep.gov.br?subject=Cadastro de descritor&body=$body\">Solicitar cadastro de novo descritor</a>";
        } else {
            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione um descritor --</option>\n";
//            $codigo .= "<optgroup label='Categorias'>\n";
            for ($i = 0; $i < sizeof($categorias); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($categorias[$i]['idDescritor']) . "\">" . $categorias[$i]['nome'] . "</option>\n";
            }
//        $codigo .= "</optgroup>\n";
            $codigo .= "</select>\n";
        }
        return $codigo;
    }

    public static function montarCaixaSelecaoComplexidades($required = false, $class = null, $id = null, $name = null) {
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

        //Não há necessidade de cadastrar no banco por enquanto, então fica um processo manual aqui
        $dificuldades = array(
            0 => array(ImagensDificuldadeEnum::SIMPLES, "Simples")
            , 1 => array(ImagensDificuldadeEnum::MEDIA, "Média")
            , 2 => array(ImagensDificuldadeEnum::COMPLEXA, "Complexa")
            , 3 => array(ImagensDificuldadeEnum::ALTA_COMPLEXIDADE, "Alta complexidade"));
        if (sizeof($dificuldades) > 0) {

            $codigo .= "<option value=\"default\" selected=\"selected\"> -- Selecione uma opção --</option>\n";
//            $codigo .= "<optgroup label='Categorias'>\n";
            for ($i = 0; $i < sizeof($dificuldades); $i++) {
                $codigo .= "<option value=\"" . fnEncrypt($dificuldades[$i][0]) . "\">" . $dificuldades[$i][1] . "</option>\n";
            }
        } else {
            //Trecho desnecessário pelo fato das complexidades serem definidas estaticamente.
            //Caso se crie um sistema dinâmico de complexidades, esse trecho terá utilidade
            $codigo .="<option value=\"default\" selected=\"selected\"> -- Não existem complexidades cadastradas --</option>\n";
        }
//        $codigo .= "</optgroup>\n";
        $codigo .= "</select>\n";
        return $codigo;
    }

    public static function montarSelecaoUsuarios($required = false, $class = null, $id = null, $name = null, $multiple = false) {
        if ($multiple) {
            $codigo = "<select multiple='multiple' size='7'";
        } else {
            $codigo = "<select size='7'";
        }
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
        $usuarioDAO = new usuarioDAO();
        $papelDAO = new papelDAO();
        for ($i = 1; $i <= Papel::__length; $i++) {
            $usuarios = $usuarioDAO->consultar("idUsuario,concat(PNome,' ',UNome) as Nome,email", "idPapel = :idPapel", array(':idPapel' => array($i, PDO::PARAM_INT)));
            if (sizeof($usuarios) == 0) {
                continue;
            } else {
                $nomePapel = $papelDAO->obterNomePapel($i);
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

