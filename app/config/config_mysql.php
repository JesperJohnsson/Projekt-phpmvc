<?php

define('DB_PASSWORD', 's6O?#L7c');

return [
    'dsn'     => "mysql:host=blu-ray.student.bth.se;dbname=jejd14;",
    'username'        => "jejd14",
    'password'        => DB_PASSWORD,
    'driver_options'  => [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
    'table_prefix'    => null,
    'verbose'           => false,
    'debug_connect' => 'true',
];
