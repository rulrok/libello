<?php

namespace app\controlador;

require_once ROOT . 'biblioteca/configuracoes.php';
require_once APP_LIBRARY_ABSOLUTE_DIR . 'seguranca/seguranca.php';
//require_once APP_DIR . 'controlador/ControladorInicial.php';
//require_once APP_DIR . 'controlador/ControladorUsuarios.php';

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

        //verifica se a classe existe
        $nome = "\\app\\controlador\\".$nomeClasseControlador;
        if (!class_exists($nome)) {
            require APP_DIR . 'visao/404.php';
            return false;
        }

        $controladorObjeto = new $nome();
        //verifica se o metodo existe
        if (!method_exists($controladorObjeto, $nomeAcao)) {
            require APP_DIR . 'visao/404.php';
            return false;
        }

        //Tudo certo
        $controladorObjeto->$nomeAcao();
        return true;
    }

    private function __clone() {
        throw Exception('Nao pode');
    }

}
