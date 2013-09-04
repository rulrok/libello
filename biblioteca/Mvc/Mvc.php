<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ROOT . 'biblioteca/configuracoes.php';
//if (file_exists(ROOT . 'biblioteca/seguranca/seguranca.php')) {
//    require ROOT . 'biblioteca/seguranca/seguranca.php';
//} else {
//    exit;
//}
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';

class Mvc {

    protected $controlador;
    protected $acao;
    private static $instancia;

    /**
     * Implementação do Singleton
     *
     * @return Planeta_Mvc 
     */
    public static function pegarInstancia() {
        //verifica se a instância existe
        if (!self::$instancia) {
            self::$instancia = new Mvc();
        }

        return self::$instancia;
    }

    /**
     * Construtor privado para forçar o Singleton
     * 
     * @return void
     */
    private function __construct() {
        
    }

    /**
     * Pega o controlador da requisição atual
     * 
     * @return string  
     */
    public function pegarControlador() {
        return $this->controlador;
    }

    /**
     * Pega a ação da requisição atual
     * 
     * @return string  
     */
    public function pegarAcao() {
        return $this->acao;
    }

    public function rodar() {
        $usuario = new Usuario();
        if (!isset($_SESSION['email'])) {
            expulsaVisitante();
        }
        $usuario->set_email($_SESSION['email']);
        $usuario->set_senha($_SESSION['senha']);
        BIBLIOTECA_DIR . 'seguranca/seguranca.php' . autenticaUsuario($usuario);

        if (isset($_SESSION['iniciada']) && $_SESSION['autenticado'] === true) {
            //pega o modulo, controlador e acao
            $controlador = isset($_GET['c']) ? $_GET['c'] : 'inicial';
            $acao = isset($_GET['a']) ? $_GET['a'] : 'inicial';

            //padronizacao de nomes
            $this->controlador = ucfirst(strtolower($controlador));
            $this->acao = ucfirst(strtolower($acao));

            $nomeClasseControlador = 'Controlador' . $this->controlador;
            $nomeAcao = 'acao' . $this->acao;

            try {
                //verifica se a classe existe
                if (class_exists($nomeClasseControlador)) {
                    $controladorObjeto = new $nomeClasseControlador;

                    //verifica se o metodo existe
                    if (method_exists($controladorObjeto, $nomeAcao)) {                
                        $controladorObjeto->$nomeAcao();
                        return true;
                    } else {
                        throw new Exception('Acao nao existente.');
                    }
                } else {
                    throw new Exception('Controlador nao existente.');
                }
            } catch (Exception $e) {
                $_GET['c'] = "Inicial";
                $_GET['a'] = "404";
                $this->rodar();
            }
        } else {
            expulsaVisitante("Você precisa estar autenticado para realizar essa operação");
        }
    }

    private function __clone() {
        throw Exception('Nao pode');
    }

}

?>
