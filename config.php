<?php
return [
    'exec-profile' => 'dev',
    'php-display-errors' => 1,
    'php-error-level' => E_ALL & ~E_WARNING,
    'socket-domain' => AF_UNIX,
    'socket-type' => SOCK_STREAM,
    'socket-protocol' => 0,
    'socket-address' => '/var/run/ks/exchange.sock',
    'socket-port' => null,
    'verbosity' => 1,
    'log-level' => 'debug',
    'exchange-pdo-dsn' => 'mysql: host=localhost;unix_socket=/var/run/mysql/mysql.sock',
    'exchange-db-name' => 'dev.exchange.cfxtrading.com',
    'exchange-db-username' => 'dev',
    'exchange-db-password' => 'dev',
    'exchange-pdo-options' => [\PDO::ERRMODE_EXCEPTION],
];

