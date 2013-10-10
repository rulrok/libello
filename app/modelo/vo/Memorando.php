<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Memorando
 *
 * @author Rodolfo
 */
class Memorando {
    //put your code here
     private $idMemorando = '';
   private $assunto = '';
   private $corpo = '';
   private $idUsuario = '';
   private $estadoValidacao = '';
   private $estadoEdicao = '';
   private $numMemorando = '';
   private $data;
   private $tipoSigla;
   private $remetente;
   private $remetente2;
   private $cargo_remetente;
   private $cargo_remetente2;
   private $tratamento;
   private $cargo_destino;
   
   public function getIdMemorando(){
       return $this->idMemorando ;
   }
    
   public function setIdMemorando($idMemorando){
       $this->idMemorando = $idMemorando ;
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
   
   public function getNumMemorando(){
       return $this->numMemorando ;
   }
    
   public function setNumMemorando($numMemorando){
       $this->numMemorando = $numMemorando ;
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
