<?php
namespace System;

class MySocket {

    private $address = '127.0.0.1';

    private $port = 8081;

    private $sock;

    private $msgsock;

    private $arq = "";

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
    public function rum () {

        if (($this->msgsock = socket_accept($this->sock)) === false) {
            echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($this->sock)) . "\n";
            break;
        }

        //aqui eu lia o arquivo
        $msg = "init";

        do {

            socket_write($this->msgsock, $msg, strlen($msg));

            do {

                if (false === ($this->socket_read_ok())) {
                    echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($this->msgsock)) . "\n";
                    break 2;
                }

                if ($this->buf_trim())
                    continue;

                if ($this->buf == 'quit')
                    break;

                if ($this->buf == 'shutdown') {
                    socket_close($this->msgsock);
                    break 2;
                }

                $get = explode(' ', $this->buf);
                //echo '<pre>';
                //var_dump($get);

                foreach ($get as $k => $v) {
                    if (substr($v, 0,1) == '/') {
                        echo $v;
                        $this->arq = $v;
                    }
                }

                if ($this->arq == "") {
                    $arquivo = file("c:\\xampp\\htdocs\\trabalho_redes_1\\arq.txt");
                    foreach($arquivo as $k => $v) {
                        $msg .= $v;
                    }
                } else {
                    $arquivo = file("c:\\xampp\\htdocs\\trabalho_redes_1{$this->arq}.txt");
                    foreach($arquivo as $k => $v) {
                        $msg .= $v;
                    }
                }
                
                //$talkback = "PHP: You said '$this->buf'.\n";
                //socket_write($this->msgsock, $talkback, strlen($talkback));
                //echo "$this->buf\n";

            } while ($this->arq == "");

            socket_close($this->msgsock);

        } while (true);

        socket_close($this->sock);
    }

    private function socket_read_ok() {
        return ($this->buf = socket_read($this->msgsock, 2048, PHP_NORMAL_READ));
    }

    private function buf_trim() {
        return !$this->buf = trim($this->buf);
    }

}

