<?php

namespace app\modelo;

require_once APP_DIR . "modelo/dao/ferramentaDAO.php";
require_once APP_DIR . "modelo/Utils.php";

final class Ferramenta extends \SplEnum {

    const __default = 0x0;
    const CONTROLE_USUARIOS = 0x01;
    const CURSOS_E_POLOS = 0x02;
    const CONTROLE_LIVROS = 0x3;
    const CONTROLE_EQUIPAMENTOS = 0x04;
    const CONTROLE_DOCUMENTOS = 0x05;
    const CONTROLE_VIAGENS = 0x06;
    const TAREFAS = 0x07;
    const GALERIA_IMAGENS = 0x08;
    const PROCESSOS = 0x09;

    /**
     * 
     * @return type
     */
    public static function obterValores() {
        return (new Ferramenta())->getConstList();
    }

    private static function _nome($ferramenta) {
        $_nomes = [
            "" //Primeira posiçao deve estar vazia
            , "Controle de usuários"
            , "Controle de Cursos e polos"
            , "Controle de livros"
            , "Controle de equipamentos"
            , "Controle de documentos"
            , "Controle de viagens"
            , "Tarefas"
            , "Galeria de imagens"
            , "Processos"
        ];

        return $_nomes[$ferramenta];
    }

    /**
     * 
     * @param int $ferramenta
     * @param boolean $normalizado
     * @param string $substitutoEspacos
     * @return type
     */
    public static function obterNome($ferramenta, $normalizado = false, $substitutoEspacos = null) {
        $nome = static::_nome($ferramenta);

        if ($normalizado) {
            $nome = strtolower(self::_normalizarNome($nome));
        }
        if ($substitutoEspacos !== null) {
            $nome = str_replace(" ", $substitutoEspacos, $nome);
        }
        return $nome;
    }

    private static function _normalizarNome($nome) {
        return removerAcentos($nome);
    }

}

?>
