<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oficio
 *
 * @author Rodolfo
 */
class Oficio {
    //put your code here
    
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
   private $remetente2;
   private $cargo_remetente;
   private $cargo_remetente2;
   private $tratamento;
   private $cargo_destino;
   
   public function getIdOficio(){
       return $this->idOficio ;
   }
    
   public function setIdOficio($idOficio){
       $this->idOficio = $idOficio ;
   }
   
   public function getAssunto(){
       return $this->assunto ;
   }
    
   public function setAssunto($assunto){
       $this->assunto = $assunto ;
   }
   
   public function getCorpo(){
       return $this->corpo ;
   }
    
   public function setCorpo($corpo){
       $this->corpo = $corpo;
   }
   
   public function getIdUsuario(){
       return $this->idUsuario ;
   }
    
   public function setIdUsuario($idUsuario){
       $this->idUsuario = $idUsuario;
   }
   
   public function getEstadoValidacao(){
       return $this->estadoValidacao ;
   }
    
   public function setEstadoValidacao($estadoValidacao){
       $this->estadoValidacao = $estadoValidacao ;
   }
   
   public function getEstadoEdicao(){
       return $this->estadoEdicao ;
   }
    
   public function setEstadoEdicao($estadoEdicao){
       $this->estadoEdicao = $estadoEdicao ;
   }
   
   public function getDestino(){
       return $this->destino ;
   }
    
   public function setDestino($destino){
       $this->destino = $destino ;
   }
   
   public function getNumOficio(){
       return $this->numOficio ;
   }
    
   public function setNumOficio($numOficio){
       $this->numOficio = $numOficio ;
   }
   
   public function getData(){
       return $this->data ;
   }
    
   public function setData($data){
       $this->data = $data ;
   }
   
   public function getTipoSigla(){
       return $this->tipoSigla ;
   }
    
   public function setTipoSigla($tipoSigla){
       $this->tipoSigla = $tipoSigla ;
   }
   
   public function getReferencia(){
       return $this->referencia ;
   }
    
   public function setReferencia($referencia){
       $this->referencia = $referencia ;
   }
   
   public function getRemetente(){
       return $this->remetente ;
   }
    
   public function setRemetente($remetente){
       $this->remetente = $remetente ;
   }
   
   public function getRemetente2(){
       return $this->remetente2 ;
   }
    
   public function setRemetente2($remetente2){
       $this->remetente2 = $remetente2 ;
   }
   
   public function getCargo_remetente(){
       return $this->cargo_remetente ;
   }
    
   public function setCargo_remetente($cargo_remetente){
       $this->cargo_remetente = $cargo_remetente ;
   }
   
   public function getCargo_remetente2(){
       return $this->cargo_remetente2 ;
   }
    
   public function setCargo_remetente2($cargo_remetente2){
       $this->cargo_remetente2 = $cargo_remetente2 ;
   }
   
   public function getTratamento(){
       return $this->tratamento ;
   }
    
   public function setTratamento($tratamento){
       $this->tratamento = $tratamento ;
   }
   
   public function getCargo_destino(){
       return $this->cargo_destino ;
   }
    
   public function setCargo_destino($cargo_destino){
       $this->cargo_destino = $cargo_destino ;
   }
   
}

?>
