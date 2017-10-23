<?php
namespace System;

class MySocket {

    private $address = '127.0.0.1';

    private $port = 8081;

    private $sock;

    private $msgsock;

    /************
    *
    * Construtor inicia a conexão com o socket
    *
    **********/
    public function __construct() {
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($this->sock, $this->address, $this->port) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
        }

        if (socket_listen($this->sock, 5) === false) {
            echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
        }
    }

    /************
    *
    * Método Rum starta o socket criado no construtor
    *
    **********/
    public function rum ($msg = null) {

        if (($this->msgsock = socket_accept($this->sock)) === false) {
            echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
            break;
        }

        if (is_null($msg)) {
            $arquivo = file("c:\\xampp\\htdocs\\trabalho_redes_1\\arq.txt");
            foreach($arquivo as $k => $v) {
                $msg .= $v;
            }
        } else {
            $arquivo = file("c:\\xampp\\htdocs\\trabalho_redes_1\\{$msg}.txt");
            foreach($arquivo as $k => $v) {
                $msg .= $v;
            }
        }
        

        do {

            socket_write($this->msgsock, $msg, strlen($msg));

            do {
                if (false === ($buf = socket_read($this->msgsock, 2048, PHP_NORMAL_READ))) {
                    echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->msgsock)) . "\n";
                    break 2;
                }
                if (!$buf = trim($buf)) {
                    continue;
                }
                if ($buf == 'quit') {
                    break;
                }
                if ($buf == 'shutdown') {
                    socket_close($this->msgsock);
                    break 2;
                }
                //$talkback = "PHP: You said '$buf'.\n";
                //socket_write($this->msgsock, $talkback, strlen($talkback));
                //echo "$buf\n";
            } while (true);
            socket_close($this->msgsock);
        } while (true);

        socket_close($this->sock);


    }

}

