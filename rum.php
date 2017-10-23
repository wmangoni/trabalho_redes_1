<?php

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

include_once "MySocket.php";

use System\MySocket;

$socket = new MySocket();
$socket->rum();