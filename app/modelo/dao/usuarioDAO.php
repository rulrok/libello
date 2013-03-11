<?php
require_once 'abstractDAO.php';
require_once __DIR__.'/../vo/Usuario.php';

class usuarioDAO extends abstractDAO {

//    protected $conexao = null;
//    public function __construct() {
//        $this->conexao = PDOconnectionFactory::getConection();
//    }
    public function atualizar($valueObject, $condicao = null) {
        
    }

    public function consultar($colunas = null, $condicao = null) {
        if ($colunas == null) {
            $colunas = "*";
        }
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM usuario " . $condicao;
        $resultado = parent::$conexao->query($sql)->fetch();
        print_r($resultado);
        return $resultado;
    }

    public function remover($valueObject) {
        
    }

    public function inserir($valueObject) {
        $s = "','";
        $login = $valueObject->get_login();
        $senha = $valueObject->get_senha();
        $PNome = $valueObject->get_PNome();
        $UNome = $valueObject->get_UNome();
        $email = $valueObject->get_email();
        $nasc = $valueObject->get_dataNascimento();
        $papel = $valueObject->get_papel();
        $sql = "INSERT INTO usuario(login,senha,PNome, UNome, email, dataNascimento,papel_idpapel)";
        $sql .= " VALUES ('" . $login . $s . $senha . $s . $PNome . $s . $UNome . $s . $email . $s . $nasc . "'," . $papel . ")";
        //    echo $sql;
        parent::$conexao->query($sql);
    }

    public function consultarPapel(Usuario $usuario) {
        $sql = "SELECT p.nome FROM papel p, usuario u WHERE u.papel_idpapel = p.idpapel AND u.login = \"" . $usuario->get_login() . "\"";
        $resultado = parent::$conexao->query($sql)->fetch();
        return $resultado[0];
    }

}

/*
  $novo = new Usuario();
  $novo->set_PNome("Reuel");
  $novo->set_UNome("Ramos");
  $novo->set_dataNascimento("28/09/1991");
  $novo->set_email("rulrok@gmail.com");
  $novo->set_login("rulrok");
  $novo->set_papel("0");
  $novo->set_senha("123456");

  
  $dao = new usuarioDAO();
  //$dao->inserir($novo);
  $r = $dao->consultarPapel($novo);
  echo $r[0];
 */
?>
