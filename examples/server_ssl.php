#!/usr/bin/env php
<?php

/*
 * This SSL server uses a self-signed certificate. This means your browser will probably
 * refuse to make Websocket connections to it. Chrome does *not* show this in the inspector.
 *
 * To add an exception, visit https://127.0.0.1:8000/ after starting this server. Then you'll
 * get the normal security prompt.
 */

require "../bootstrap.php";

// Generate PEM file
$pemFile                = dirname(__FILE__) . '/generated.pem';
$pemPassphrase          = null;
$countryName            = "DE";
$stateOrProvinceName    = "none";
$localityName           = "none";
$organizationName       = "none";
$organizationalUnitName = "none";
$commonName             = "127.0.0.1";
$emailAddress           = "someone@example.com";

Wrench_Util_Ssl::generatePEMFile(
    $pemFile,
    $pemPassphrase,
    $countryName,
    $stateOrProvinceName,
    $localityName,
    $organizationName,
    $organizationalUnitName,
    $commonName,
    $emailAddress
);

// User can use tls in place of ssl
$server = new Wrench_Server('wss://0.0.0.0:8000/', array(
     'connection_manager_options' => array(
         'socket_master_options' => array(
             'server_ssl_local_cert'        => $pemFile,
             'server_ssl_passphrase'        => $pemPassphrase,
             'server_ssl_allow_self_signed' => true,
             'server_ssl_verify_peer'       => false
         )
     )
));

$server->registerApplication('echo', new Wrench_Application_EchoApplication());
$server->registerApplication('time', new Wrench_Application_ServerTimeApplication());
$server->run();
