<?php

require_once 'abstractDAO.php';
require_once __DIR__ . '/../vo/Usuario.php';
require_once __DIR__ . '/../vo/PermissoesFerramenta.php';
require_once __DIR__ . '/../../../biblioteca/seguranca/Ferramenta.php';
require_once __DIR__ . '/../../../biblioteca/seguranca/Permissao.php';

class usuarioDAO extends abstractDAO {

//    protected $conexao = null;
//    public function __construct() {
//        $this->conexao = PDOconnectionFactory::getConection();
//    }
    public function atualizar(Usuario $valueObject, $condicao = null) {
        
    }

    public static function consultar($colunas = null, $condicao = null) {
        if ($colunas == null) {
            $colunas = "*";
        }
        if ($condicao == null) {
            $condicao = "";
        } else {
            $condicao = "WHERE " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM usuario " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function remover(Usuario $valueObject) {
        
    }

    public static function inserir(Usuario $valueObject) {
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
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function consultarPapel(Usuario $usuario) {
        $sql = "SELECT p.nome FROM papel p, usuario u WHERE u.papel_idpapel = p.idpapel AND u.login = \"" . $usuario->get_login() . "\"";
        $resultado = parent::getConexao()->query($sql)->fetch();
        return $resultado[0];
    }

    public static function obterPermissoes(Usuario $usuario) {
        $sql = "SELECT f.idFerramenta,nomeFerramenta,tp.idPermissao,tipoPermissao FROM ferramenta f, permissao tp, usuario_permissao p WHERE f.idFerramenta = p.idFerramenta AND tp.idPermissao = p.idPermissao AND idUsuario = " . $usuario->get_id() . " ORDER BY idFerramenta";
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    /**
     * Altera as permissões do usuário com base nas configurações definidas em $permissoes.
     * Parâmetros que estão definidos como NULL em $permissoes, não serão alterados.
     * 
     * @param Usuario $usuario Objeto com a id do usuário.
     * @param PermissoesFerramenta $permissoes Permissões para cada ferramenta.
     * @return boolean
     */
    public static function alterarPermissoes(Usuario $usuario, PermissoesFerramenta $permissoes) {
        if ($usuario->get_id() != null) {
            $consulta = self::consultar("idUsuario", "idUsuario = " . $usuario->get_id());
            $querys;
            if (sizeof($consulta) == 1) {
                for ($i = 0; $i < Ferramenta::__length; $i++) {
                    if ($permissoes->get_permissao($i + 1) != null) {
                        $querys[sizeof($querys)] = "UPDATE usuario_permissao SET idPermissao = " . $permissoes->get_permissao($i + 1) . " WHERE idUsuario = " . $usuario->get_id() . " AND idFerramenta = " . ($i + 1);
                    }
                }
                foreach ($querys as $query) {
                    parent::getConexao()->query($query);
                }
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Cadastra permissões para um usuário pela primeira vez, no ato do cadastro.
     * @param Usuario $usuario
     * @param PermissoesFerramenta $permissoes
     */
    public static function cadastrarPermissoes(Usuario $usuario, PermissoesFerramenta $permissoes) {
        if ($usuario->get_login() != null) {
                $consulta = self::consultar("idUsuario", "login = \"" . $usuario->get_login()."\"");
            $values = array();
            if (sizeof($consulta) == 1) {
                for ($i = 0; $i < Ferramenta::__length; $i++) {
                    if ($permissoes->get_permissao($i + 1) != null) {
                        $values[sizeof($values)] = "(" . $consulta[0]['idUsuario'] . "," . ($i + 1) . "," . $permissoes->get_permissao($i + 1) . ")";
                    } else {
                        $values[sizeof($values)] = "(" . $consulta[0]['idUsuario'] . "," . ($i + 1) . "," . Permissao::SEM_ACESSO . ")";
                    }
                }
                $sql = "INSERT INTO usuario_permissao (idUsuario, idFerramenta, idPermissao) VALUES ".$values[0];
                for ($i = 1; $i < sizeof($values);$i++) {
                    $sql .= " ,".$values[$i];
                }
                $sql = str_pad($sql, strlen($sql)-2);
                parent::getConexao()->query($sql);
            }
        } else {
            return false;
        }
    }

}

?>
