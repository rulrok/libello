<?php

class Usuario {

    var $idUsuario;
    var $idPapel;
    var $senha;
    var $PNome;
    var $UNome;
    var $email;
    var $dataNascimento;
    var $iniciais;
    var $cpf;

    public function get_idUsuario() {
        return $this->idUsuario;
    }

    public function set_idUsuario($id) {
        $this->idUsuario = $id;
        return $this;
    }

    public function get_idPapel() {
        return $this->idPapel;
    }

    public function get_senha() {
        return $this->senha;
    }

    public function get_PNome() {
        return $this->PNome;
    }

    public function get_UNome() {
        return $this->UNome;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_dataNascimento() {
        return $this->dataNascimento;
    }

    public function get_iniciais() {
        return $this->iniciais;
    }

    public function get_cpf() {
        return $this->cpf;
    }

    public function set_idPapel($idPapel) {
        $this->idPapel = $idPapel;
        return $this;
    }

    public function set_senha($senha) {
        $this->senha = $senha;
        return $this;
    }

    public function set_PNome($PNome) {
        $this->PNome = $PNome;
        return $this;
    }

    public function set_UNome($UNome) {
        $this->UNome = $UNome;
        return $this;
    }

    public function set_email($email) {
        $this->email = $email;
        return $this;
    }

    public function set_dataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function set_iniciais($iniciais) {
        $this->iniciais = $iniciais;
        return $this;
    }

    public function set_cpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

}

?>
