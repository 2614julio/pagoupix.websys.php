<?php

 /* cobrei.vc
  * @PicPay Pagamentos
  * Simples integração com PicPay
  * Documentação: https://bit.ly/2VfBmjD
  */

  class PicPayClass{

	 /*
	  *@var type String: $urlCallBack
	  */
	  public $urlCallBack;

	  /*
	   *@var type String: $urlReturn
	   */
	  public $urlReturn;

    /*
     *@var type String: $x_picpay_token
     */
    public $x_picpay_token;

    /*
     *@var type String: $x_seller_token
     */
    public $x_seller_token;


	 //Função que faz a requisição
	 public function requestPayment($produto,$cliente){

		  $data = array(
		         'referenceId' => $produto->ref,
		         'callbackUrl' => $this->urlCallBack,
		         'returnUrl'   => $this->urlReturn,
		         'value'       => $produto->valor,
		         'buyer'       => [
						  'firstName' => $cliente->nome,
						  'lastName'  => $cliente->sobreNome,
						  'document'  => $cliente->cpf,
						  'email'     => $cliente->email,
						  'phone'     => $cliente->telefone
						],
					);

		 $ch = curl_init('https://appws.picpay.com/ecommerce/public/payments');
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		 curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-picpay-token: '.$this->x_picpay_token));

		 $res = curl_exec($ch);
		 curl_close($ch);
	     $return = json_decode($res);

		 return $return;

	 }



	 // Notificação PicPay
	 public function notificationPayment(){

		$content = trim(file_get_contents("php://input"));
	    $payBody = json_decode($content);

		 if(isset($payBody->authorizationId)):

		   $referenceId = $payBody->referenceId;

		   $ch = curl_init('https://appws.picpay.com/ecommerce/public/payments/'.$referenceId.'/status');
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-picpay-token: '.$this->x_picpay_token));

		   $res = curl_exec($ch);
		   curl_close($ch);
		   $notification = json_decode($res);

		   $notification->referenceId     = $payBody->referenceId;
		   $notification->authorizationId = $payBody->authorizationId;

		   return $notification;

		 else:

			return false;

		 endif;


	 }




  }





?>
