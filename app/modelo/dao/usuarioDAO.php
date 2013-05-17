<?php

require_once 'abstractDAO.php';
require_once __DIR__ . '/../vo/Usuario.php';
require_once __DIR__ . '/../vo/PermissoesFerramenta.php';
require_once __DIR__ . '/../Ferramenta.php';
require_once BIBLIOTECA_DIR . 'seguranca/Permissao.php';

class usuarioDAO extends abstractDAO {

    /**
     * Atualiza informações de um usuário. O email não é alterado, pois ele é a
     * chave primaria no banco de dados.
     * @param type $email Usado para localizar o usuário no banco de dados.
     * @param Usuario $usuario Objecto VO com as novas informações.
     * @return boolean
     */
    public static function atualizar($email, Usuario $novosDados) {

        $dadosAntigos = usuarioDAO::recuperarUsuario($email);

        $condicao = " WHERE email = '" . $email . "' AND ativo = 1";

        $nome = $novosDados->get_PNome();
        if ($nome == null) {
            $nome = $dadosAntigos->get_PNome();
        }
        $sobrenome = $novosDados->get_UNome();
        if ($sobrenome == null) {
            $sobrenome = $dadosAntigos->get_UNome();
        }
        $papel = (int) $novosDados->get_papel();
        if ($papel == null) {
            $papel = $dadosAntigos->get_papel();
        }
        $senha = $novosDados->get_senha();
        if ($senha == null) {
            $senha = $dadosAntigos->get_senha();
        }
//        $email = $usuario->get_email();
        $dataNascimento = $novosDados->get_dataNascimento();
        if ($dataNascimento == null) {
            $dataNascimento = $dadosAntigos->get_dataNascimento();
        }

        $sql = "UPDATE usuario SET idPapel = " . $papel . ", senha = '" . $senha . "', PNome='" . $nome . "', UNome = '" . $sobrenome . "', dataNascimento = '" . $dataNascimento . "'";
        $sql .= $condicao;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
            exit;
            return false;
        }
    }

    /**
     * Retorna a lista com todos os usuários, com base nas colunas especificadas e nas condições de seleção.
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public static function consultar($colunas = "*", $condicao = null) {

        if ($condicao == null) {
            $condicao = "WHERE ativo = 1";
        } else {
            $condicao = "WHERE ativo = 1 AND " . $condicao;
        }
        $sql = "SELECT " . $colunas . " FROM usuario NATURAL JOIN papel " . $condicao;
        $resultado = parent::getConexao()->query($sql)->fetchAll();
        return $resultado;
    }

    public static function remover($email) {
        if ($email !== null) {
            if (is_array($email)) {
                $email = $email['email'];
            }
            $email = "'" . $email . "'";
            $sql = "UPDATE usuario SET ativo = 0 WHERE email = " . $email;
            try {
                parent::getConexao()->query($sql);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    /**
     * Retorna o email do usuário COMO STRING com base em seu id no banco de dados. 
     * Retorna NULL caso não exista.
     */
    public static function descobrirEmail($id) {
        if ($id != null) {
            $sql = "SELECT email FROM usuario WHERE idUsuario = " . $id;
            try {
                $email = parent::getConexao()->query($sql)->fetch();
            } catch (Exception $e) {
                $email = null;
            }
            if (is_array($email)) {
                $email = $email['email'];
            }
            return $email;
        }
    }

    /**
     * Insere um novo usuário no banco de dados.
     * @param Usuario $valueObject Objeto com as informações do novo usuário.
     * @return boolean
     */
    public static function inserir(Usuario $valueObject) {
        $s = "','";
//        $login = $valueObject->get_login();
        $senha = $valueObject->get_senha();
        $PNome = $valueObject->get_PNome();
        $UNome = $valueObject->get_UNome();
        $email = $valueObject->get_email();
        $nasc = $valueObject->get_dataNascimento();
        $idPapel = $valueObject->get_papel() + 1;
        $sql = "INSERT INTO usuario(idPapel,senha,PNome, UNome, email, dataNascimento)";
        $sql .= " VALUES (" . $idPapel . ",'" . $senha . $s . $PNome . $s . $UNome . $s . $email . $s . $nasc . "')";
        //    echo $sql;
        try {
            parent::getConexao()->query($sql);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Retorna uma string contendo o nome do papel do usuário, e.g, 'Administrador', 'Professor', etc.
     * @param $usuario Email do usuário.
     * @return type
     */
    public static function consultarPapel($email) {
        $sql = "SELECT p.nome FROM papel p NATURAL JOIN usuario u WHERE u.email = \"" . $email . "\"";
        $resultado = parent::getConexao()->query($sql)->fetch();
        return $resultado[0];
    }

    /**
     * Gera um tolken e armazena na tabela 'usuariosRecuperarSenha'.
     * @param type $email
     */
    public static function gerarTolkenRecuperarSenha($email) {
        $usuario = usuarioDAO::recuperarUsuario($email);
        $antigaSenhaMD5 = $usuario->get_senha();
        $hora = time();
        $id = $usuario->get_id();
        $tolken = md5($antigaSenhaMD5 . $hora);
        $sql = "INSERT INTO usuariosRecuperarSenha VALUES (" . $id . ",\"" . $tolken . "\")";
        try {
            parent::getConexao()->query($sql);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Caso o usuário queira redefinir sua senha, um tolken é gerado e armazenado
     * na tabela 'usuariosRecuperarSenha'. Essa função retorna esse tolken, caso
     * ele exista, ou NULL caso contrário.
     * 
     * @param type $email
     */
    public static function consultarTolkenRecuperarSenha($id) {
        $sql = "SELECT tolken FROM usuariosRecuperarSenha WHERE idUsuario = " . $id;
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    /**
     * Consulta o usuário associado ao tolken, mas apenas se o usuário quis redefinir
     * sua senha.
     * @param type $tolken
     */
    public static function consultarIDUsuario_RecuperarSenha($tolken) {
        $sql = "SELECT idUsuario FROM usuariosRecuperarSenha WHERE tolken = \"" . $tolken . "\"";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    /**
     * Remove um tolken do banco de dados.
     * @param type $tolken
     */
    public static function removerTolken($tolken) {
        $sql = "DELETE FROM usuariosRecuperarSenha WHERE tolken = \"" . $tolken . "\"";
        try {
            $resultado = parent::getConexao()->query($sql)->fetch();
        } catch (Exception $e) {
            echo $e;
        }
        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    /**
     * Retorna um objeto VO Usuário se o usuário existe E está ativo, ou então retorna NULL.
     * @param type $email Email do usuário
     */
    public static function recuperarUsuario($email) {

        if (is_array($email)) {
            $email = $email['email'];
        }

        $sql = "SELECT * from usuario WHERE email ='" . $email . "' AND ativo = 1";
        try {
            $stmt = parent::getConexao()->query($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
//            if ($usuario == null) {
//                $usuario = "Usuário não encontrado";
//            }
        } catch (Exception $e) {
            $usuario = NULL;
        }
        return $usuario;
    }

    public static function obterPermissoes($idUsuario) {
        $sql = "SELECT f.idFerramenta,f.nome,tp.idPermissao,tp.tipo FROM ferramenta f, permissao tp, usuario_x_permissao_x_ferramenta p WHERE f.idFerramenta = p.idFerramenta AND tp.idPermissao = p.idPermissao AND idUsuario = " . $idUsuario . " ORDER BY idFerramenta";
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
                        $querys[sizeof($querys)] = "UPDATE usuario_x_permissao_x_ferramenta SET idPermissao = " . $permissoes->get_permissao($i + 1) . " WHERE idUsuario = " . $usuario->get_id() . " AND idFerramenta = " . ($i + 1);
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
        if ($usuario->get_email() != null) {
            $consulta = self::consultar("idUsuario", "email = \"" . $usuario->get_email() . "\"");
            $values = array();
            if (sizeof($consulta) == 1) {
                for ($i = 0; $i < Ferramenta::__length; $i++) {
                    if ($permissoes->get_permissao($i + 1) != null) {
                        $values[sizeof($values)] = "(" . $consulta[0]['idUsuario'] . "," . ($i + 1) . "," . $permissoes->get_permissao($i + 1) . ")";
                    } else {
                        $values[sizeof($values)] = "(" . $consulta[0]['idUsuario'] . "," . ($i + 1) . "," . Permissao::SEM_ACESSO . ")";
                    }
                }
                $sql = "INSERT INTO usuario_x_permissao_x_ferramenta (idUsuario, idFerramenta, idPermissao) VALUES " . $values[0];
                for ($i = 1; $i < sizeof($values); $i++) {
                    $sql .= " ," . $values[$i];
                }
                $sql = str_pad($sql, strlen($sql) - 2);
                try {
                    parent::getConexao()->query($sql);
                } catch (Exception $e) {
                    return false;
                }
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Atualiza as permissões de um usuário já existente, conforme as novas permissões
     * passados como parâmetro.
     * 
     * @param Usuario $usuario
     * @param PermissoesFerramenta $permissoes
     * @return boolean True se cadastrado com sucesso, false caso contrário.
     */
    public static function atualizarPermissoes(Usuario $usuario, PermissoesFerramenta $permissoes) {
        if ($usuario !== null && $permissoes !== null) {
            $idUsuario = $usuario->get_id();
            if ($idUsuario == null) {
                $idUsuario = usuarioDAO::recuperarUsuario($usuario->get_email())->get_id();
            }

            $sql = "DELETE FROM usuario_x_permissao_x_ferramenta WHERE idUsuario =  " . $idUsuario;
            try {
                parent::getConexao()->query($sql);
            } catch (Exception $e) {
                return false;
            }
            usuarioDAO::cadastrarPermissoes($usuario, $permissoes);
            return true;
        } else {
            return false;
        }
    }

}

?>
