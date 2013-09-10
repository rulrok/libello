<?php

require_once BIBLIOTECA_DIR . 'configuracoes.php';
require_once BIBLIOTECA_DIR . 'bancoDeDados/PDOconnectionFactory.php';

/**
 * Centraliza as requisições para conexão com o banco de dados.
 */
abstract class abstractDAO {

    public static $conexao = null;

    public static function getConexao() {
        if (self::$conexao == null) {
            self::$conexao = PDOconnectionFactory::getConection();
        }
        return self::$conexao;
    }

    /**
     * Coloca a string entre aspas e trata aspas internas dela. Caso a string
     * seja igual a NULL, a própria string será retornada.
     * 
     * @param type $string
     * @return type Uma string entre aspas.
     */
    public static function quote($string) {
        if ($string == "NULL") {
            return $string;
        }
        return self::getConexao()->quote($string);
    }

    /*
      abstract function atualizar($valueObject, $condicao = null);

      abstract function consultar($colunas = null, $condicao = null);

      abstract function inserir($valueObject);

      abstract function remover($valueObject);
     */
}

?>
