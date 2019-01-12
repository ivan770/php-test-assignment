<?php

// Подключаем composer autoload
require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// Создаём соединение для Eloquent
$capsule = new Capsule();

$capsule->addConnection([
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'database' => '',
    'username' => '',
    'password' => '',
]);
// Делаем соединение глобальным
$capsule->setAsGlobal();
// Запускаем Eloquent
$capsule->bootEloquent();
