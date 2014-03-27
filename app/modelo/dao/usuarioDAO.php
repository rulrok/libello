<?php

require_once 'abstractDAO.php';
require_once APP_DIR . 'modelo/vo/Usuario.php';
require_once APP_DIR . 'modelo/vo/PermissoesFerramenta.php';
require_once APP_DIR . 'modelo/enumeracao/Ferramenta.php';
require_once BIBLIOTECA_DIR . 'seguranca/Permissao.php';
require_once BIBLIOTECA_DIR . 'seguranca/criptografia.php';

class usuarioDAO extends abstractDAO {

    /**
     * Atualiza informações de um usuário. O email não é alterado.
     * @param type $email Usado para localizar o usuário no banco de dados.
     * @param Usuario $novosDados Objecto VO com as novas informações.
     * @return boolean
     */
    public function atualizar($email, Usuario $novosDados) {

        $dadosAntigos = $this->recuperarUsuario($email);

        $condicao = " WHERE email = :email AND ativo = 1";

        $nome = $novosDados->get_PNome();
        if ($nome == null) {
            $nome = $dadosAntigos->get_PNome();
        }
        $sobrenome = $novosDados->get_UNome();
        if ($sobrenome == null) {
            $sobrenome = $dadosAntigos->get_UNome();
        }
        $idPapel = (int) $novosDados->get_idPapel();
        if ($idPapel == null) {
            $idPapel = $dadosAntigos->get_idPapel();
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

        $cpf = $novosDados->get_cpf();
        if ($cpf == null) {
            $cpf = $dadosAntigos->get_cpf();
        }

        $sql = "UPDATE usuario SET idPapel = :idPapel, senha = :senha, PNome= :PNome, UNome = :UNome, dataNascimento = :dataNascimento, cpf = :cpf ";
        $sql .= $condicao;
        $params = array(
            ':email' => [$email, PDO::PARAM_STR]
            , ':idPapel' => [$idPapel, PDO::PARAM_INT]
            , ':senha' => [$senha, PDO::PARAM_STR]
            , ':PNome' => [$nome, PDO::PARAM_STR]
            , ':UNome' => [$sobrenome, PDO::PARAM_STR]
            , ':dataNascimento' => [$dataNascimento, PDO::PARAM_STR]
            , ':cpf' => [$cpf, PDO::PARAM_STR]
        );
        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna a lista com todos os usuários, com base nas colunas especificadas e nas condições de seleção.
     * @param string $colunas Colunas a serem retornadas, por padrão, retorna
     * @param type $condicao A string que precede WHERE na cláusula SQL. Não é necessário escrever a palavra WHERE.
     * @return type A tabela com o resultado da consulta.
     */
    public function consultar($colunas = '*', $condicao = null, $parametros = null) {

        if ($condicao == null) {
            $condicao = 'WHERE ativo = 1';
        } else {
            $condicao = 'WHERE ativo = 1 AND ' . $condicao;
        }
        $sql = "SELECT  $colunas  FROM usuario NATURAL JOIN usuario_papel " . $condicao;
        return $this->executarSelect($sql, $parametros);
    }

    public function desativar($email) {
        if ($email !== null) {
            if (is_array($email)) {
                $email = $email['email'];
            }
            $sql = 'UPDATE usuario SET ativo = 0 WHERE email = :email';
            $params = array(':email' => [$email, PDO::PARAM_STR]);
            return $this->executarQuery($sql, $params);
        }
    }

    /**
     * Retorna o email do usuário cadastrado
     * @param int $idUsuario
     * @return string
     */
    public function descobrirEmail($idUsuario) {
        if ($idUsuario != null) {
            $sql = 'SELECT email FROM usuario WHERE idUsuario = :idUsuario';
            $params = array(':idUsuario' => [$idUsuario, PDO::PARAM_INT]);
            return $this->executarSelect($sql, $params, false);
        }
    }

    /**
     * Insere um novo usuário no banco de dados.
     * @param Usuario $vo Objeto com as informações do novo usuário.
     * @return boolean
     */
    public function inserir(Usuario $vo) {
        $sql = 'INSERT INTO usuario(idPapel,senha,PNome, UNome, email, dataNascimento, cpf) VALUES (  :idPapel, :senha, :PNome, :UNome, :email, :nasc, :cpf )';
        $cpf = str_replace(array('.', '-'), '', $vo->get_cpf());
        $params = array(
            ':idPapel' => [$vo->get_idPapel(), PDO::PARAM_INT]
            , ':senha' => [$vo->get_senha(), PDO::PARAM_STR]
            , ':PNome' => [$vo->get_PNome(), PDO::PARAM_STR]
            , ':UNome' => [$vo->get_UNome(), PDO::PARAM_STR]
            , ':email' => [$vo->get_email(), PDO::PARAM_STR]
            , ':nasc' => [$vo->get_dataNascimento(), PDO::PARAM_STR]
            , ':cpf' => [$cpf, PDO::PARAM_STR]
        );

        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna uma string contendo o nome do papel do usuário, e.g, 'Administrador', 'Professor', etc.
     * @param string Email do usuário.
     * @return array
     */
    public function consultarPapel($email) {
        $sql = 'SELECT p.nome FROM usuario_papel p NATURAL JOIN usuario u WHERE u.email = :email';
        $params = array(':email' => array($email, PDO::PARAM_STR));
        return $this->executarSelect($sql, $params, false);
    }

    /**
     * Gera um token e armazena na tabela 'usuario_recuperarsenha'.
     * 
     * @param type $email
     * @return boolean Indica se o token já existia cadastrado, ou seja,
     * que o usuário já havia solicitado a recuperação de senha
     */
    public function gerarTokenRecuperarSenha($email) {
        $usuario = $this->recuperarUsuario($email);
        $sqlTokenExistente = "SELECT token FROM usuario_recuperarsenha WHERE idUsuario = :idUsuario";
        $paramTokenExistente = array(
            ':idUsuario' => [$usuario->get_idUsuario(), PDO::PARAM_INT]
        );
        $resultado = $this->executarSelect($sqlTokenExistente, $paramTokenExistente);
        if ($resultado !== null && !empty($resultado)) {
            return true;
        } elseif ($usuario !== null) {
            $antigaSenhaMD5 = $usuario->get_senha();
            $hora = time();
            $idUsuario = $usuario->get_idUsuario();
            $token = encriptarSenha($antigaSenhaMD5 . $hora);
            $sql = 'INSERT INTO usuario_recuperarsenha VALUES (:idUsuario, :token)';
            $params = array(
                ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
                , ':token' => [$token, PDO::PARAM_STR]
            );
            $this->executarQuery($sql, $params);
        }
        return false;
    }

    /**
     * Caso o usuário queira redefinir sua senha, um token é gerado e armazenado
     * na tabela 'usuario_recuperarsenha'. Essa função retorna esse token, caso
     * ele exista, ou NULL caso contrário.
     * 
     * @param type int
     * @return string Description
     */
    public function consultarTokenRecuperarSenha($idUsuario) {
        $sql = 'SELECT token FROM usuario_recuperarsenha WHERE idUsuario = :idUsuario';
        $params = array(':idUsuario' => [$idUsuario, PDO::PARAM_INT]);
        return $this->executarSelect($sql, $params, false);
    }

    /**
     * Consulta o usuário associado ao token, mas apenas se o usuário quis redefinir
     * sua senha.
     * @param type $token
     */
    public function consultarIDUsuario_RecuperarSenha($token) {
        $sql = "SELECT idUsuario FROM usuario_recuperarsenha WHERE token = :token";
        $params = array(':token' => [$token, PDO::PARAM_INT]);
        $resultado = $this->executarSelect($sql, $params, false);
        if ($resultado === null) {
            throw new Exception('Token não encontrado');
        }
        if (is_array($resultado)) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    /**
     * Remove um token do banco de dados.
     * @param type $token
     */
    public function removerToken($token) {
        $sql = "DELETE FROM usuario_recuperarsenha WHERE token = :token";
        $params = array(':token' => [$token, PDO::PARAM_STR]);
        return $this->executarQuery($sql, $params);
    }

    /**
     * Retorna um objeto VO Usuário se o usuário existe E está ativo, ou então retorna NULL.
     * Todos os seus dados cadastrados são inclusos, inclusive o ID atual.
     * @param mixed $email Uma string ou um array com um índice 'email'
     * @return Usuario Usuário que possui o email designado em $email ou false caso contrário
     */
    public function recuperarUsuario($email) {

        if (is_array($email)) {
            $email = $email['email'];
        }

        $sql = "SELECT * from usuario WHERE email = :email AND ativo = 1";
        $params = array(':email' => [$email, PDO::PARAM_INT]);
        $resultado = $this->executarSelect($sql, $params, false, 'Usuario');
        return $resultado;
    }

    public function obterPermissoes($idUsuario) {
        $sql = "SELECT f.idFerramenta,f.nome,tp.idPermissao,tp.tipo FROM sistema_ferramenta f, usuario_permissao tp, usuario_x_permissao_x_ferramenta p WHERE f.idFerramenta = p.idFerramenta AND tp.idPermissao = p.idPermissao AND idUsuario =  :idUsuario  ORDER BY idFerramenta";
        $params = array(
            ':idUsuario' => [$idUsuario, PDO::PARAM_INT]
        );
        return $this->executarSelect($sql, $params);
    }

    /**
     * Altera as permissões do usuário com base nas configurações definidas em $permissoes.
     * Parâmetros que estão definidos como NULL em $permissoes, não serão alterados.
     * 
     * @param Usuario $usuario Objeto com a id do usuário.
     * @param PermissoesFerramenta $permissoes Permissões para cada ferramenta.
     * @return boolean
     */
    public function alterarPermissoes(Usuario $usuario, PermissoesFerramenta $permissoes) {
        if ($usuario->get_idUsuario() != null) {
            $consulta = $this->consultar('idUsuario', 'idUsuario = :idUsuario', array(':idUsuario' => [(int) $usuario->get_idUsuario(), PDO::PARAM_INT]));
//            $querys = array();
            $query = 'UPDATE usuario_x_permissao_x_ferramenta SET idPermissao = :idPermissao WHERE idUsuario = :idUsuario AND idFerramenta = :idFerramenta';
            $parametros = array();
            if (sizeof($consulta) == 1) {
                for ($i = 0; $i < Ferramenta::__length; $i++) {
                    if ($permissoes->get_permissao($i + 1) != null) {
//                        $querys[] = 'UPDATE usuario_x_permissao_x_ferramenta SET idPermissao = :idPermissao WHERE idUsuario = :idUsuario AND idFerramenta = :idFerramenta';
                        $parametros[] = array(
                            ':idPermissao' => [(int) $permissoes->get_permissao($i + 1), PDO::PARAM_INT]
                            , ':idUsuario' => [(int) $usuario->get_idUsuario(), PDO::PARAM_INT]
                            , ':idFerramenta' => [((int) $i + 1), PDO::PARAM_INT]
                        );
                    } else {
                        //TODO tratar esse suposto caso
                        return false;
                    }
                }
                for ($i = 0; $i < count($parametros); $i++) {
                    if (!$this->executarQuery($query, $parametros[$i])) {
                        return false;
                    }
                }
                return true; //Saída com sucesso da função
            }
        } else {
            return false;
        }
    }

//TODO Método medonho. Precisa ser melhorado
    /**
     * Cadastra permissões para um usuário pela primeira vez, no ato do cadastro.
     * @param Usuario $usuario
     * @param PermissoesFerramenta $permissoes
     */
    public function cadastrarPermissoes(Usuario $usuario, PermissoesFerramenta $permissoes) {
        if ($usuario->get_email() != null) {
            $consulta = $this->consultar('idUsuario', "email = :email", array(':email' => [$usuario->get_email(), PDO::PARAM_STR]));
//            $values = array();
            if (sizeof($consulta) == 1) {
//                for ($i = 0; $i < Ferramenta::__length; $i++) {
//                    if ($permissoes->get_permissao($i + 1) != null) {
//                        $values[sizeof($values)] = '(' . $consulta[0]['idUsuario'] . ',' . ($i + 1) . ',' . $permissoes->get_permissao($i + 1) . ')';
//                    } else {
//                        $values[sizeof($values)] = '(' . $consulta[0]['idUsuario'] . ',' . ($i + 1) . ',' . Permissao::SEM_ACESSO . ')';
//                    }
//                }
                $parametros = array();
                for ($i = 0; $i < Ferramenta::__length; $i++) {
                    if ($permissoes->get_permissao($i + 1) != null) {
                        $parametros[] = array(
                            ':idPermissao' => [(int) $permissoes->get_permissao($i + 1), PDO::PARAM_INT]
                            , ':idUsuario' => [(int) $usuario->get_idUsuario(), PDO::PARAM_INT]
                            , ':idFerramenta' => [((int) $i + 1), PDO::PARAM_INT]
                        );
                    } else {
                        //TODO tratar esse suposto caso
                        return false;
                    }
                }
                $sql = 'INSERT INTO usuario_x_permissao_x_ferramenta (idUsuario, idFerramenta, idPermissao) VALUES (:idUsuario, :idFerramenta, :idPermissao)';

//                for ($i = 1; $i < sizeof($values); $i++) {
//                    $sql .= ' ,' . $values[$i];
//                }
//                $sql = str_pad($sql, strlen($sql) - 2);
//                return $this->executarQuery($values);
                for ($i = 0; $i < count($parametros); $i++) {
                    if (!$this->executarQuery($sql, $parametros[$i])) {
                        return false;
                    }
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
    public function atualizarPermissoes(Usuario &$usuario, PermissoesFerramenta $permissoes) {
        if ($usuario !== null && $permissoes !== null) {
            $idUsuario = $usuario->get_idUsuario();
            if ($idUsuario == null) {
                $idUsuario = $this->recuperarUsuario($usuario->get_email())->get_idUsuario();
                $usuario->set_idUsuario($idUsuario);
            }

            $sql = 'DELETE FROM usuario_x_permissao_x_ferramenta WHERE idUsuario =  :idUsuario';
            if (!$this->executarQuery($sql, array(':idUsuario' => [$idUsuario, PDO::PARAM_INT]))) {
                return false;
            }
            $this->cadastrarPermissoes($usuario, $permissoes);
            return true;
        } else {
            return false;
        }
    }

}

?>
