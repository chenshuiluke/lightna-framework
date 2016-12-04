<?php
namespace Lightna;

//Due to the .htaccess file, all requests are rerouted to this file.
require 'config.php';
require 'request.php';
Config::onLoad();
Request::onLoad();
Request::printContents();
?>