<?php

 /**
 * Email
 */
class Email extends Conn{
    
  public $from;
  
  public $to;
  
  public $content;
  
  public $params;
  
  public $subject;

  public $erro;    
    
  function __construct(){
      
    $this->conn      = new Conn;
    $this->pdo       = $this->conn->pdo();

  }

 public function render(){
     
     $keys = array_keys($this->params);
     $content = str_replace($keys, array_values($this->params), $this->content);
     $this->content = $content;
     
 }

 public function sendMail(){
     
    $this->render();
     
    $cabecalhos  = 'MIME-Version: 1.0' . "\r\n";
    $cabecalhos .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabecalhos .= 'From: '.$this->from['name'].' <'.$this->from['email'].'>' . "\r\n";
    
    if (mail($this->to, $this->subject, $this->content, $cabecalhos)) {
      $this->erro = false;
    } else {
      $this->erro = true;
    }
    
 }
 
  public function generateCode($tamanho = 5) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $codigo;
    }

 

}
