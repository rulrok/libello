<?php

require_once 'abstractDAO.php';
//require_once APP_LOCATION . 'modelo/vo/ImagemCategoria.php';
require_once APP_LOCATION . 'modelo/vo/Descritor.php';
require_once APP_LOCATION . 'modelo/enumeracao/TipoEventoImagens.php';
require_once APP_LOCATION . 'modelo/enumeracao/ImagensDescritor.php';

class imagensDAO extends abstractDAO {

    public function consultarGaleria($nomeGaleria) {
        $nomeGaleria = parent::quote($nomeGaleria);
        $sql = "SELECT idGaleria FROM imagens_galeria WHERE nomeGaleria LIKE " . $nomeGaleria;

        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public function cadastrarGaleria($nomeGaleria) {
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

    public function todasImagens($limit = "") {
        $sql = "SELECT * FROM imagens_imagem ORDER BY idImagem $limit";
        return $this->executarSelect($sql);
    }

    public function pesquisarImagem($termoBusca, $limit = "") {
        //TODO melhorar bastante essa função
        $sql = "SELECT * from imagens_imagem WHERE titulo LIKE :termoBusca ORDER BY idImagem $limit";
        $params = array(
            ':termoBusca' => ["%$termoBusca%", PDO::PARAM_STR]
        );
        return $this->executarSelect($sql, $params);
    }

    public function consultarDescritoresPais($colunas = "*", $condicao = null, $condicaoJuncao = null) {

        if ($condicao == null) {
            $condicao = " WHERE pai = " . ImagensDescritor::RAIZ_ID;
        } else {
            $condicao = " WHERE pai = " . ImagensDescritor::RAIZ_ID . " AND " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT " . $colunas . " FROM imagens_descritor " . $condicaoJuncao . $condicao;

        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public function consultarDescritor($colunas = "*", $condicao = null, $condicaoJuncao = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }

        $sql = "SELECT " . $colunas . " FROM imagens_descritor " . $condicaoJuncao . $condicao;

        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public function consultarCaminhoDescritores($idDescritorBase) {
        $caminho = array();

        $resultado = static::consultarDescritor('nome, pai', "idDescritor = $idDescritorBase");


        while ($resultado[0]['pai'] != null) {
            array_push($caminho, $resultado[0]['nome']);
            $aux = (int) $resultado[0]['pai'];
            $resultado = static::consultarDescritor('nome, pai', "idDescritor = $aux");
        }



        $endereco = "";
        $i = sizeof($caminho);
        for (; $i > 0; $i--) {
            $endereco .= array_pop($caminho) . " > ";
        }
        return $endereco . "'Novo descritor'";
    }

    public function consultarDescritoresFilhos($colunas = "*", $condicao = null, $condicaoJuncao = null) {
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = " WHERE " . $condicao;
        }

        if ($condicaoJuncao == null) {
            $condicaoJuncao = "";
        }
        $sql = "SELECT $colunas FROM imagens_descritor " . $condicaoJuncao . $condicao;
        return $this->executarSelect($sql);
    }

    public function cadastrarCategoria(ImagemCategoria $categoria) {
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

    public function cadastrarImagem(Imagem $imagem) {
        $sql = "INSERT INTO imagens_imagem(idGaleria,titulo,observacoes,dificuldade,cpfAutor,ano,nomeArquivo,nomeArquivoMiniatura,nomeArquivoVetorial,descritor1,descritor2,descritor3,descritor4) VALUES ";
        $idGaleria = (int) $imagem->get_idGaleria();
//        $idSubcategoria = (int) $imagem->get_idSubcategoria();
        $titulo = parent::quote($imagem->get_titulo());
        $observacoes = parent::quote($imagem->get_observacoes());
        $dificuldade = parent::quote($imagem->get_dificuldade());
        $cpfAutor = parent::quote($imagem->get_cpfAutor());
        $ano = parent::quote($imagem->get_ano());
        $nomeArquivo = parent::quote($imagem->get_nomeArquivo());
        $nomeArquivoMiniatura = parent::quote($imagem->get_nomeArquivoMiniatura());
        $nomeArquivoVetorial = parent::quote($imagem->get_nomeArquivoVetorial());
        $des1 = $imagem->get_descritor1();
        $des2 = $imagem->get_descritor2();
        $des3 = $imagem->get_descritor3();
        $des4 = $imagem->get_descritor4();
        $values = "($idGaleria,$titulo,$observacoes,$dificuldade,$cpfAutor,$ano,$nomeArquivo,$nomeArquivoMiniatura,$nomeArquivoVetorial,$des1,$des2,$des3,$des4)";
        try {
            parent::getConexao()->query($sql . $values);
            return true;
        } catch (Exception $e) {
            echo $e;
            echo $sql . $values;
            return false;
        }
    }

//    public function consultarImagem(Imagem $imagem) {
////        $sql = "SELECT count(idPolo) FROM polo WHERE ";
////        $nome = parent::quote($polo->get_nome());
////        $cidade = parent::quote($polo->get_cidade());
////        $estado = parent::quote($polo->get_estado());
////        $condicao = "nomePolo = $nome AND cidade=$cidade AND estado = $estado";
////        try {
////            $resultado = parent::getConexao()->query($sql . $condicao)->fetch();
////        } catch (Exception $e) {
////            echo $e;
////        }
////
////        if (is_array($resultado)) {
////            $resultado = $resultado[0];
////        }
////        return $resultado;
//    }

    public function removerCategoria($idCategoria) {
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

    public function atualizarDescritor($idCategoria, Descritor $novosDados) {

        $idCategoria = (int) $idCategoria;
        $dadosAntigos = (new imagensDAO())->recuperarDescritor($idCategoria);

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

    /** Retorna a lista com todos os polos, com base nas colunas especificadas e nas condições de seleção.
     * 
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public function consultar($colunas = "*", $condicao = null) {

//        if ($condicao == null) {
//            $condicao = "";
//        }
//        $sql = "SELECT " . $colunas . " FROM polo " . $condicao;
//        $resultado = parent::getConexao()->query($sql)->fetchAll();
//        return $resultado;
    }

    public function recuperarDescritor($idDescritor) {

        $sql = "SELECT * from imagens_descritor WHERE idDescritor = :idDescritor";
        $params = array(
            ':idDescritor' => [$idDescritor, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params, false, 'Descritor');
    }

    public function recuperarSubcategoria($subcategoriaID) {
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

    public function registrarRemocaoCategoria() {
        $quote = "\"";
        $tipo = TipoEventoImagens::REMOCAO_CATEGORIA;
        $usuarioID = obterUsuarioSessao()->get_idUsuario();
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

    public function registrarRemocaoSubcategoria() {
        $quote = "\"";
        $tipo = TipoEventoImagens::REMOCAO_SUBCATEGORIA;
        $usuarioID = obterUsuarioSesget_idUsuario > get_id();
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

    public function registrarAlteracaoCategoria($idCategoria) {
        $quote = "\"";
        $tipo = TipoEventoImagens::ALTERACAO_CATEGORIA;
        $usuarioID = obterUsuget_idUsuariossao()->get_id();
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

    public function registrarAlteracaoSubcategoria($idSubcategoria) {
        $quote = "\"";
        $tipo = TipoEventoImagens::ALTERACAO_CATEGORIA;
        $usuarioID = oget_idUsuariouarioSessao()->get_id();
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

    public function registrarCadastroImagem($idImagem) {
        $quote = "\"";
        $tipo = TipoEventoImagens::CADASTRO_IMAGEM;
        $usuariget_idUsuarioobterUsuarioSessao()->get_id();
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
