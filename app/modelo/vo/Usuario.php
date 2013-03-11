<?php
class Usuario {
    var $idUsuario;
    var $login;
    var $senha;
    var $PNome;
    var $UNome;
    var $email;
    var $dataNascimento;
    var $papel_idpapel;
    
    public function get_id() {
        return $this->idUsuario;
    }

    public function set_id($id) {
        $this->idUsuario = $id;
    }

    public function get_login() {
        return $this->login;
    }

    public function set_login($login) {
        $this->login = $login;
    }

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
        return $this->papel_idpapel;
    }

    public function set_papel($papel) {
        $this->papel_idpapel = (int)$papel;
    }


}

?>
