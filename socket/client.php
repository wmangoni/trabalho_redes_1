<?php
error_reporting(E_ALL);
$service_port = 8081;
$address = gethostbyname('127.0.0.1');

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
}

$in = "HEAD / HTTP/1.1\r\n";
$in .= "Host: {$address}\r\n";
$in .= "Connection: Close\r\n\r\n";
$out = '';

socket_write($socket, $in, strlen($in));

// while ($out = socket_read($socket, 2048)) {
//    echo $out;
// }

$out = socket_read($socket, 2048);
echo $out;

echo "Closing socket...";
socket_close($socket);
echo "OK.\n\n";
?>