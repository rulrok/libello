<?php

namespace app\modelo;

require_once APP_DIR . "modelo/dao/ferramentaDAO.php";

final class Ferramenta {

    const __default = self::DESCONHECIDO;
    const __length = 8;
    const DESCONHECIDO = 0x00;
    const CONTROLE_USUARIOS = 0x01;
    const CURSOS_E_POLOS = 0x02;
    const CONTROLE_LIVROS = 0x3;
    const CONTROLE_EQUIPAMENTOS = 0x04;
    const CONTROLE_DOCUMENTOS = 0x05;
    const CONTROLE_VIAGENS = 0x06;
    const TAREFAS = 0x07;
    const GALERIA_IMAGENS = 0x08;

    public static function get_codigo_ferramenta($nomeFerramenta) {
        $nomeFerramenta = strtolower($nomeFerramenta);
        $nomeFerramenta = str_ireplace("controle", "", $nomeFerramenta);
        switch ($nomeFerramenta) {
            case "cursospolos":
                return Ferramenta::CURSOS_E_POLOS;
            case "documentos":
                return Ferramenta::CONTROLE_DOCUMENTOS;
            case "equipamentos":
                return Ferramenta::CONTROLE_EQUIPAMENTOS;
            case "livros":
                return Ferramenta::CONTROLE_LIVROS;
            case "tarefas":
                return Ferramenta::TAREFAS;
            case "usuarios":
                return Ferramenta::CONTROLE_USUARIOS;
            case "viagens":
                return Ferramenta::CONTROLE_VIAGENS;
            case "imagens":
                return Ferramenta::GALERIA_IMAGENS;
        }
    }

}

?>
