<?php

class Usuario {

    var $idUsuario;
    var $idPapel = null;
//    var $login;
    var $senha;
    var $PNome;
    var $UNome;
    var $email;
    var $dataNascimento;
    var $iniciais;
    var $cpf;

    public function get_id() {
        return $this->idUsuario;
    }

    public function set_id($id) {
        $this->idUsuario = $id;
    }

//    public function get_login() {
//        return $this->login;
//    }
//
//    public function set_login($login) {
//        $this->login = $login;
//    }

    public function get_senha() {
        return $this->senha;
    }

    public function set_senha($senha) {
        $this->senha = $senha;
    }

    public function get_PNome() {
        return $this->PNome;
    }

    public function set_PNome($PNome) {
        $this->PNome = $PNome;
    }

    public function get_UNome() {
        return $this->UNome;
    }

    public function set_UNome($UNome) {
        $this->UNome = $UNome;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_dataNascimento() {
        return $this->dataNascimento;
    }

    public function set_dataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function get_papel() {
        return $this->idPapel;
    }

    public function set_papel($papel) {
        $this->idPapel = (int) $papel;
    }

    public function get_cpf() {
        return $this->cpf;
    }

    public function set_cpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

    public function get_iniciais() {
        return $this->iniciais;
    }

    public function set_iniciais($iniciais) {
        $this->iniciais = $iniciais;
        return $this;
    }

    //TODO Retirar essas verificações da classe VO. Erros de quando o projeto ainda estava surgindo
    /**
     * Função auxiliar para verificar se os campos do objeto usuário que são requeridos para inserir no banco de dados não são vazios
     * 
     * @return boolean
     */
    public function validarCampos() {
        if ($this->PNome !== null && $this->PNome !== "" && $this->UNome !== null && $this->UNome !== ""
//                && $this->login !== null && $this->login !== ""
                && $this->senha !== null && $this->senha !== "" && $this->idPapel !== null && $this->email !== null && $this->email !== "" && $this->cpf !== null && $this->cpf !== "") {
            return true;
        }
        return false;
    }

}

?>
