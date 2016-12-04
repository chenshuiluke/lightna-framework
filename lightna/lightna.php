<?php
namespace Lightna;
require 'config.php';
require 'request.php';
Config::onLoad();

$request = new Request();
echo nl2br("URL: " . $request->getURL() . "\n");
echo nl2br("Port: " . $request->getPort() . "\n");
echo nl2br("Host: " . $request->getHost() . "\n");
echo nl2br("Uri: " . $request->getUri() . "\n");
?>