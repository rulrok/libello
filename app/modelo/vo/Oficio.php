<?php
namespace app\modelo;

/**
 * Description of Oficio
 *
 * @author Rodolfo
 */
class Oficio {
    
   private $idOficio = '';
   private $assunto = '';
   private $corpo = '';
   private $idUsuario = '';
   private $estadoValidacao = '';
   private $estadoEdicao = '';
   private $destino = '';
   private $numOficio = '';
   private $data;
   private $tipoSigla;
   private $referencia;
   private $remetente;
   private $cargo_remetente;
   private $tratamento;
   private $cargo_destino;
   
   public function get_idOficio() {
       return $this->idOficio;
   }

   public function get_assunto() {
       return $this->assunto;
   }

   public function get_corpo() {
       return $this->corpo;
   }

   public function get_idUsuario() {
       return $this->idUsuario;
   }

   public function get_estadoValidacao() {
       return $this->estadoValidacao;
   }

   public function get_estadoEdicao() {
       return $this->estadoEdicao;
   }

   public function get_destino() {
       return $this->destino;
   }

   public function get_numOficio() {
       return $this->numOficio;
   }

   public function get_data() {
       return $this->data;
   }

   public function get_tipoSigla() {
       return $this->tipoSigla;
   }

   public function get_referencia() {
       return $this->referencia;
   }

   public function get_remetente() {
       return $this->remetente;
   }

   public function get_cargo_remetente() {
       return $this->cargo_remetente;
   }

   public function get_tratamento() {
       return $this->tratamento;
   }

   public function get_cargo_destino() {
       return $this->cargo_destino;
   }

   public function set_idOficio($idOficio) {
       $this->idOficio = $idOficio;
       return $this;
   }

   public function set_assunto($assunto) {
       $this->assunto = $assunto;
       return $this;
   }

   public function set_corpo($corpo) {
       $this->corpo = $corpo;
       return $this;
   }

   public function set_idUsuario($idUsuario) {
       $this->idUsuario = $idUsuario;
       return $this;
   }

   public function set_estadoValidacao($estadoValidacao) {
       $this->estadoValidacao = $estadoValidacao;
       return $this;
   }

   public function set_estadoEdicao($estadoEdicao) {
       $this->estadoEdicao = $estadoEdicao;
       return $this;
   }

   public function set_destino($destino) {
       $this->destino = $destino;
       return $this;
   }

   public function set_numOficio($numOficio) {
       $this->numOficio = $numOficio;
       return $this;
   }

   public function set_data($data) {
       $this->data = $data;
       return $this;
   }

   public function set_tipoSigla($tipoSigla) {
       $this->tipoSigla = $tipoSigla;
       return $this;
   }

   public function set_referencia($referencia) {
       $this->referencia = $referencia;
       return $this;
   }

   public function set_remetente($remetente) {
       $this->remetente = $remetente;
       return $this;
   }

   public function set_cargo_remetente($cargo_remetente) {
       $this->cargo_remetente = $cargo_remetente;
       return $this;
   }

   public function set_tratamento($tratamento) {
       $this->tratamento = $tratamento;
       return $this;
   }

   public function set_cargo_destino($cargo_destino) {
       $this->cargo_destino = $cargo_destino;
       return $this;
   }


}

?>
