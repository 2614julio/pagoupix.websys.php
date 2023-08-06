<?php 

 require_once '../../panel/class/Conn.class.php';
 require_once '../../panel/class/Callback.class.php';

 $request = $_REQUEST;
 $callback = new Callback($request,'picpay');
 $callback->callback();

?>