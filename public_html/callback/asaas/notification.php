<?php 

 $server = (object) $_SERVER;
 $contents = "$server->REQUEST_METHOD $server->REQUEST_URI $server->SERVER_PROTOCOL\n";
 foreach(getallheaders() as $key => $value) $contents .= "$key: $value\n";
 $payload = file_get_contents('php://input');
 $contents .= "\n".$payload;
 file_put_contents('request-'.microtime(true), $contents);

 require_once '../../panel/class/Conn.class.php';
 require_once '../../panel/class/Callback.class.php';

 $request = $_REQUEST;
 $callback = new Callback($request,'asaas');
 $callback->callback();

?>