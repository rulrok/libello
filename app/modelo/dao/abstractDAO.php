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
    
    public static function quote($string){
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
