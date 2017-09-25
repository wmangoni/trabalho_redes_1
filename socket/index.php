<?php
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
//set_time_limit(0);

if (isset($_POST['send'])) {

	$host = "127.0.0.1";
	$port = 8081;
	$msg = "Hello server";

	$sock = socket_create(AF_INET,SOCK_STREAM,0) or die("Cannot create a socket");
	socket_connect($sock,$host,$port) or die("Could not connect to the socket");
	socket_write($sock,$msg, strlen($msg));

	$read = socket_read($sock,1024);
	$read = trim($read);
	$read = "Server says:\t" . $read;
	
	socket_close($sock);

	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sockets</title>
		<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
	</head>
<body>

	<div class="container">
		<h1>Trabalho socket</h1>
		<form method="post">
		
		<input type="text" name="msg" />
		<input type="submit" name="send" value="send" />
		
		</form>
		
		<p><?= isset($read) ? $read : "[...]" ?></p>
		
	</div>

</body>
</html>