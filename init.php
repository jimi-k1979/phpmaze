<?php

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$cxn = new PDO($_ENV['DB_CONNECTION'].':host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

