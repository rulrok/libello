<?php

require_once 'abstractDAO.php';
require_once APP_LOCATION . 'modelo/vo/ImagemCategoria.php';
require_once APP_LOCATION . 'modelo/enumeracao/TipoEventoImagens.php';

class imagensDAO extends abstractDAO {

    public static function consultarGaleria($nomeGaleria) {
        $nomeGaleria = parent::quote($nomeGaleria);
        $sql = "SELECT idGaleria FROM imagens_galeria WHERE nomeGaleria LIKE " . $nomeGaleria;

        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function cadastrarGaleria($nomeGaleria) {
        $nomeGaleria = parent::quote($nomeGaleria);
        $data = parent::quote(date('Y-m-j'));
        $sql = "INSERT INTO imagens_galeria(nomeGaleria,qtdFotos,dataCriacao) VALUES ($nomeGaleria,0,$data)";

        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function consultarCategorias($colunas = "*", $condicao = null, $condicaoJuncao = null) {

        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT " . $colunas . " FROM imagens_categoria " . $condicaoJuncao . $condicao;

        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function consultarSubcategorias($colunas = "*", $condicao = null, $condicaoJuncao = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }
        $sql = "SELECT " . $colunas . " FROM imagens_subcategoria " . $condicaoJuncao . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function cadastrarCategoria(ImagemCategoria $categoria) {
        $sql = "INSERT INTO imagens_categoria(nomeCategoria) VALUES ";
        $nomeCategoria = parent::quote($categoria->get_nomeCategoria());
        $values = "($nomeCategoria)";
        try {
            parent::getConexao()->query($sql . $values);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function cadastrarSubcategoria(ImagemSubcategoria $subcategoria) {
        $sql = "INSERT INTO imagens_subcategoria(nomeSubcategoria,categoriaPai) VALUES ";
        $nomeCategoria = parent::quote($subcategoria->get_nomeSubcategoria());
        $categoriaPai = $subcategoria->get_categoriaPai();
        $values = "($nomeCategoria,$categoriaPai)";
        try {
            parent::getConexao()->query($sql . $values);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function cadastrarImagem(Imagem $imagem) {
        $sql = "INSERT INTO imagens_imagem(idGaleria,idSubcategoria,titulo,observacoes,descritor1,descritor2,descritor3,dificuldade,cpfAutor,ano,nomeArquivo,nomeArquivoMiniatura,nomeArquivoVetorial) VALUES ";
        $idGaleria = (int) $imagem->get_idGaleria();
        $idSubcategoria = (int) $imagem->get_idSubcategoria();
        $titulo = parent::quote($imagem->get_titulo());
        $observacoes = parent::quote($imagem->get_observacoes());
        $descritor1 = parent::quote($imagem->get_descritor1());
        $descritor2 = parent::quote($imagem->get_descritor2());
        $descritor3 = parent::quote($imagem->get_descritor3());
        $dificuldade = parent::quote($imagem->get_dificuldade());
        $cpfAutor = parent::quote($imagem->get_cpfAutor());
        $ano = parent::quote($imagem->get_ano());
        $nomeArquivo = parent::quote($imagem->get_nomeArquivo());
        $nomeArquivoMiniatura = parent::quote($imagem->get_nomeArquivoMiniatura());
        $nomeArquivoVetorial = parent::quote($imagem->get_nomeArquivoVetorial());
        $values = "($idGaleria,$idSubcategoria,$titulo,$observacoes,$descritor1,$descritor2,$descritor3,$dificuldade,$cpfAutor,$ano,$nomeArquivo,$nomeArquivoMiniatura,$nomeArquivoVetorial)";
        try {
            parent::getConexao()->query($sql . $values);
            return true;
        } catch (Exception $e) {
            echo $e;
            echo $sql . $values;
            return false;
        }
    }

    public static function consultarImagem(Imagem $imagem) {
//        $sql = "SELECT count(idPolo) FROM polo WHERE ";
//        $nome = parent::quote($polo->get_nome());
//        $cidade = parent::quote($polo->get_cidade());
//        $estado = parent::quote($polo->get_estado());
//        $condicao = "nomePolo = $nome AND cidade=$cidade AND estado = $estado";
//        try {
//            $resultado = parent::getConexao()->query($sql . $condicao)->fetch();
//        } catch (Exception $e) {
//            echo $e;
//        }
//
//        if (is_array($resultado)) {
//            $resultado = $resultado[0];
//        }
//        return $resultado;
    }

    public static function removerCategoria($idCategoria) {
        if ($idCategoria !== null) {
            if (is_array($idCategoria)) {
                $idCategoria = $idCategoria['categoriaID'];
            }
            $idCategoria = (int) $idCategoria;
            $sql = "DELETE FROM imagens_categoria WHERE idCategoria = " . $idCategoria;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function removerSubcategoria($idSubcategoria) {
        if ($idSubcategoria !== null) {
            if (is_array($idSubcategoria)) {
                $idSubcategoria = $idSubcategoria['subcategoriaID'];
            }
            $idSubcategoria = (int) $idSubcategoria;
            $sql = "DELETE FROM imagens_subcategoria WHERE idSubcategoria = " . $idSubcategoria;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public static function remover($idPolo) {
//        if ($idPolo !== null) {
//            if (is_array($idPolo)) {
//                $idPolo = $idPolo['poloID'];
//            }
//            $idPolo = (int) $idPolo;
//            $sql = "DELETE FROM polo WHERE idPolo = " . $idPolo;
//            try {
//                parent::getConexao()->query($sql);
//                return true;
//            } catch (Exception $e) {
//                return false;
//            }
//        }
    }

    public static function atualizar($idPolo, Polo $novosDados) {

//        $idPolo = (int) $idPolo;
//        $dadosAntigos = poloDAO::recuperarPolo($idPolo);
//
//        $condicao = " WHERE idPolo = " . $idPolo;
//
//        $nome = $novosDados->get_nome();
//        if ($nome == null) {
//            $nome = $dadosAntigos->get_nome();
//        }
//
//        $cidade = $novosDados->get_cidade();
//        if ($cidade == null) {
//            $cidade = $dadosAntigos->get_cidade();
//        }
//
//        $estado = $novosDados->get_estado();
//        if ($estado == null) {
//            $estado = $dadosAntigos->get_estado();
//        }
//
//
//        $sql = "UPDATE polo SET nomePolo = '" . $nome . "' ,cidade = '" . $cidade . "' ,estado = '" . $estado."'";
//        $sql .= $condicao;
//        try {
//            parent::getConexao()->query($sql);
//            return true;
//        } catch (Exception $e) {
//            echo $e;
//            exit;
//            return false;
//        }
    }

    public static function atualizarCategoria($idCategoria, ImagemCategoria $novosDados) {

        $idCategoria = (int) $idCategoria;
        $dadosAntigos = imagensDAO::recuperarCategoria($idCategoria);

        $condicao = " WHERE idCategoria = " . $idCategoria;

        $nome = $novosDados->get_nomeCategoria();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nomeCategoria();
        }


        $sql = "UPDATE imagens_categoria SET nomeCategoria = '" . $nome . "'";
        $sql .= $condicao;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function atualizarSubcategoria($idSubcategoria, ImagemSubcategoria $novosDados) {

        $idSubcategoria = (int) $idSubcategoria;
        $dadosAntigos = imagensDAO::recuperarSubcategoria($idSubcategoria);

        $condicao = " WHERE idSubcategoria = " . $idSubcategoria;

        $nome = $novosDados->get_nomeSubcategoria();
        if ($nome == null) {
            $nome = $dadosAntigos->get_nomeSubcategoria();
        }
        $categoriaPai = (int) $novosDados->get_categoriaPai();
        if ($categoriaPai == null) {
            $categoriaPai = $dadosAntigos->get_categoriaPai();
        }


        $sql = "UPDATE imagens_subcategoria SET nomeSubcategoria = '" . $nome . "', categoriaPai = $categoriaPai";
        $sql .= $condicao;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /** Retorna a lista com todos os polos, com base nas colunas especificadas e nas condições de seleção.
     * 
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public static function consultar($colunas = "*", $condicao = null) {

//        if ($condicao == null) {
//            $condicao = "";
//        }
//        $sql = "SELECT " . $colunas . " FROM polo " . $condicao;
//        $resultado = parent::getConexao()->query($sql)->fetchAll();
//        return $resultado;
    }

    public static function recuperarPolo($poloID) {
//        if (is_array($poloID)) {
//            $poloID = $poloID['cursoID'];
//        }
//
//        $sql = "SELECT * from polo WHERE idPolo ='" . $poloID . "'";
//        try {
//            $stmt = parent::getConexao()->query($sql);
//            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Polo');
//            $polo = $stmt->fetch();
////            if ($usuario == null) {
////                $usuario = "Usuário não encontrado";
////            }
//        } catch (Exception $e) {
//            $polo = NULL;
//        }
//        return $polo;
    }

    public static function recuperarCategoria($categoriaID) {
        if (is_array($categoriaID)) {
            $categoriaID = $categoriaID['categoriaID'];
        }

        $sql = "SELECT * from imagens_categoria WHERE idCategoria ='" . $categoriaID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'ImagemCategoria');
            $categoria = $stmt->fetch();
//            if ($usuario == null) {
//                $usuario = "Usuário não encontrado";
//            }
        } catch (Exception $e) {
            $categoria = NULL;
        }
        return $categoria;
    }

    public static function recuperarSubcategoria($subcategoriaID) {
        if (is_array($subcategoriaID)) {
            $subcategoriaID = $subcategoriaID['subcategoriaID'];
        }

        $sql = "SELECT * from imagens_subcategoria WHERE idSubcategoria ='" . $subcategoriaID . "'";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'ImagemSubcategoria');
            $categoria = $stmt->fetch();
//            if ($usuario == null) {
//                $usuario = "Usuário não encontrado";
//            }
        } catch (Exception $e) {
            $categoria = NULL;
        }
        return $categoria;
    }

    public static function registrarRemocaoCategoria() {
        $quote = "\"";
        $tipo = TipoEventoImagens::REMOCAO_CATEGORIA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO imagens_evento(tipoEvento,usuario,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarRemocaoSubcategoria() {
        $quote = "\"";
        $tipo = TipoEventoImagens::REMOCAO_SUBCATEGORIA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO imagens_evento(tipoEvento,usuario,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarAlteracaoCategoria($idCategoria) {
        $quote = "\"";
        $tipo = TipoEventoImagens::ALTERACAO_CATEGORIA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO imagens_evento(tipoEvento,usuario,categoria,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idCategoria,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarAlteracaoSubcategoria($idSubcategoria) {
        $quote = "\"";
        $tipo = TipoEventoImagens::ALTERACAO_CATEGORIA;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO imagens_evento(tipoEvento,usuario,subcategoria,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idSubcategoria,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

    public static function registrarCadastroImagem($idImagem) {
        $quote = "\"";
        $tipo = TipoEventoImagens::CADASTRO_IMAGEM;
        $usuarioID = obterUsuarioSessao()->get_id();
        $sql = "INSERT INTO imagens_evento(tipoEvento,usuario,imagem,data,hora) VALUES ";
        $sql .= " ($tipo,$usuarioID,$idImagem,<data>,<hora>)";
        $sql = str_replace("<data>", $quote . date('Y-m-j') . $quote, $sql);
        $sql = str_replace("<hora>", $quote . date('h:i:s') . $quote, $sql);
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            print_r($e);
            return false;
        }
    }

}

?>
