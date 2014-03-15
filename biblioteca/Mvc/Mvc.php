<?php

require_once ROOT . 'biblioteca/configuracoes.php';
require_once BIBLIOTECA_DIR . 'seguranca/seguranca.php';

class Mvc {

    /**
     *
     * @var string Nome do controlador
     */
    protected $controlador;

    /**
     *
     * @var string Nome da ação
     */
    protected $acao;

    /**
     *
     * @var \MVC Singleton
     */
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
//        $usuario = new Usuario();
//        session_start();
//        if (!isset(obterUsuarioSessao())) {
//            expulsaVisitante();
//        }
//        $usuario->set_email(obterUsuarioSessao()->get_email());
//        $usuario->set_senha(obterUsuarioSessao()->get_senha());
//        BIBLIOTECA_DIR . 'seguranca/seguranca.php' . autenticaUsuario($usuario);


        if (!sessaoIniciada()) {
            expulsaVisitante("Você precisa estar autenticado para realizar essa operação");
        }
        //pega o modulo, controlador e acao
        $controlador = filter_has_var(INPUT_GET, 'c') ? filter_input(INPUT_GET, 'c') : 'inicial';
        $acao = filter_has_var(INPUT_GET, 'a') ? filter_input(INPUT_GET, 'a') : 'inicial';

        //padronizacao de nomes
        $this->controlador = ucfirst(strtolower($controlador));
        $this->acao = ucfirst(strtolower($acao));

        $nomeClasseControlador = 'Controlador' . $this->controlador;
        $nomeAcao = 'acao' . $this->acao;

        try {
            //verifica se a classe existe
            if (!class_exists($nomeClasseControlador)) {
                throw new Exception('Controlador nao existente.');
            }
            $controladorObjeto = new $nomeClasseControlador;

            //verifica se o metodo existe
            if (!method_exists($controladorObjeto, $nomeAcao)) {
                throw new Exception('Acao nao existente.');
            }
//            if (usuarioAutorizado(obterUsuarioSessao(), $controladorObjeto, $nomeAcao)) {
            $controladorObjeto->$nomeAcao();
            return true;
//            } else {
//                //Carrega uma página de acesso proibido
//                $controladorObjeto = new ControladorInicial();
//                $this->controlador = "Inicial";
//                $this->acao = "acessoProibido";
//                $controladorObjeto->acaoAcessoProibido();
//                return true;
//            }
        } catch (Exception $e) {
            print_r($e);

            $_GET['c'] = "Inicial";
            $_GET['a'] = "404";
            //TODO Verificar se isso não pode gerar uma recursão sem fim!
            $this->rodar();
        }
    }

    private function __clone() {
        throw Exception('Nao pode');
    }

}