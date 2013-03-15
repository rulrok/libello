<?php

require __DIR__.'/../../../biblioteca/bancoDeDados/PDOconnectionFactory.php';


abstract class abstractDAO {

    public static $conexao = null;

    public static function getConexao() {
        if (self::$conexao == null){
        self::$conexao = PDOconnectionFactory::getConection();
        }
        return self::$conexao;
    }
    /*
    abstract function atualizar($valueObject, $condicao = null);
    
    abstract function consultar($colunas = null, $condicao = null);

    abstract function inserir($valueObject);
    
    abstract function remover($valueObject);
*/
}

?>
