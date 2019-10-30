<?php

declare(strict_types=1);

error_reporting(E_ERROR | E_PARSE);

$server = stream_socket_server('tcp://127.0.0.1:7181', $errno, $errstr);

if ($server === false) {
    fwrite(STDERR, "Error: $errno: $errstr");

    exit(1);
}

fwrite(STDERR, sprintf("Listening on: %s\n", stream_socket_get_name($server, false)));

while (true) {
    $connection = stream_socket_accept($server, 1, $clientAddress);

    if ($connection) {
        fwrite(STDERR, "Client [{$clientAddress}] connected \n");

        while ($buffer = fread($connection, 2048)) {
            if ($buffer !== '') {
                fwrite($connection, "Server says: $buffer");
            }
        }

        fclose($connection);
    } else {
        fwrite(STDERR, "Aguardando ... \n");
    }
}
