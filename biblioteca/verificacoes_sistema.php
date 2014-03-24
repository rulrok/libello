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
        $this->verificar_tamanho_maximo_upload();
        $this->verificarTiposImagensSuportados();
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

    /*
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

    private function verificar_tamanho_maximo_upload() {

        function convertBytes($value) {
            if (is_numeric($value)) {
                return $value;
            } else {
                $value_length = strlen($value);
                $qty = substr($value, 0, $value_length - 1);
                $unit = strtolower(substr($value, $value_length - 1));
                switch ($unit) {
                    case 'k':
                        $qty *= 1024;
                        break;
                    case 'm':
                        $qty *= 1048576;
                        break;
                    case 'g':
                        $qty *= 1073741824;
                        break;
                }
                return $qty;
            }
        }

        $tamanhoMaximo = convertBytes(ini_get('upload_max_filesize'));
        if ($tamanhoMaximo < APP_MAX_UPLOAD_SIZE) {
            $this->anexarMensagemErro("Tamanho máximo para uploads definido pela sua instalação PHP é menor que o limite máximo definido nas configurações do aplicativo!");
        }
    }

    private function verificarTiposImagensSuportados() {
        if (!(imagetypes() & IMG_PNG)) {
            $this->anexarMensagemErro("Sua instalação não suporta tipos de imagens PNG");
        }
        if (!(imagetypes() & IMG_JPEG)){
            $this->anexarMensagemErro("Sua instalação não suporta tipos de imagens JPG/JPEG");
        }
    }

}
