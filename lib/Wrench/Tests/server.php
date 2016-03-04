<?php

require_once(__DIR__ . '/../../../bootstrap.php');

if ($argc != 2 || !$argv[1] || !is_numeric($argv[1]) || (int)$argv[1] <= 1024) {
    throw new InvalidArgumentException('Invalid port number: supply as first argument');
}

$port = (int)$argv[1];

$server = new Wrench_Server('ws://localhost:' . $port);
$server->registerApplication('echo', new Wrench_Application_EchoApplication());
$server->run();