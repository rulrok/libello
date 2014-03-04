<?php

class verificador_instalacao {

    /**
     *
     * @var boolean 
     */
    var $tudoCerto = true;

    /**
     *
     * @var string 
     */
    var $resultadoAnalise;

    /**
     *
     * @var \DOMDocument 
     */
    var $dom;

    public function testar() {
        $this->dom = new DOMDocument('1.0', 'utf-8');
        $this->realizar_testes();
    }

    public function tudoCerto() {
        return $this->tudoCerto;
    }

    public function mensagensErro() {
        return $this->dom->saveHTML();
    }

    /*
     * MÉTODOS PRIVADOS
     */

    /**
     * Métodos auxiliares
     */
    private function realizar_testes() {
        $this->testar_diretorio_privado();
        $this->testar_diretorio_temporario();
        $this->testar_diretorio_galerias();
    }

    private function erroEncontrado() {
        $this->tudoCerto = false;
    }

    private function anexarMensagemErro($mensagem) {
        $this->erroEncontrado();
        $elemento = $this->dom->createTextNode($mensagem);
        $this->dom->appendChild($elemento);
        $br = $this->dom->createElement('br');
        $this->dom->appendChild($br);
    }

    private function testar_diretorio($diretorio, $nomeDiretorio) {
        if (!file_exists($diretorio)) {
            $this->anexarMensagemErro("Diretório $nomeDiretorio não existe no servidor");
        } elseif (!is_writable($diretorio)) {
            $this->erroEncontrado();
            if (!is_readable($diretorio)) {
                $this->anexarMensagemErro("Diretório $nomeDiretorio não é gravável nem legível");
            } else {
                $this->anexarMensagemErro("Diretório $nomeDiretorio não é gravável");
            }
        }
    }

    /**
     * Métodos gerais
     * Os testes devem ser escritos nesta parte do código
     */
    private function testar_diretorio_temporario() {
        $this->testar_diretorio(APP_TEMP_DIR, 'temporário');
    }

    private function testar_diretorio_privado() {
        $this->testar_diretorio(APP_PRIVATE_DIR, 'privado');
    }

    private function testar_diretorio_galerias() {
        $this->testar_diretorio(APP_GALLERY_DIR, 'galeria de imagens');
    }

}
