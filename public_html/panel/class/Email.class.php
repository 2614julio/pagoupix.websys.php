<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Email
 */
class Email extends Conn {

    public $from;
    public $to;
    public $content;
    public $params;
    public $subject;
    public $erro;

    public $error_reason = false;

    function __construct() {
        $this->conn = new Conn;
        $this->pdo  = $this->conn->pdo();
    }

    public function render() {
        $keys = array_keys($this->params);
        $content = str_replace($keys, array_values($this->params), $this->content);
        $this->content = $content;
    }

    public function sendMail() {
        $this->render();

        $cabecalhos  = 'MIME-Version: 1.0' . "\r\n";
        $cabecalhos .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $cabecalhos .= 'From: '.$this->from['name'].' <'.$this->from['email'].'>' . "\r\n";

        if (in_array($_SERVER['SERVER_NAME'], ['localhost', 'pagoupix.computatus.org'])) {
            $mail = new PHPMailer(true);
            try {

                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = 'mail.computatus.org';
                $mail->Username   = 'mailler@computatus.org';
                $mail->Password   = 'HzzABT9p5rifEwW';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('no-reply@pagoupix.com.br');
                $mail->addAddress($this->to);

                $mail->isHTML(true);
                $mail->Subject = $this->subject;
                $mail->Body = $this->content;

                $mail->send();

                $this->erro = false;

            }
            catch (Exception $ex) {
                $this->erro = true;
                $this->error_reason = $ex->getMessage();
            }
        }
        else {
            if (mail($this->to, $this->subject, $this->content, $cabecalhos)) $this->erro = false;
            else {
                $this->erro = true;
                $this->error_reason = null;
            }
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