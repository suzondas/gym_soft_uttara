<?php
require 'tad/vendor/autoload.php';
require 'tad/lib/TADFactory.php';
require 'tad/lib/TAD.php';
require 'tad/lib/TADResponse.php';
require 'tad/lib/Providers/TADSoap.php';
require 'tad/lib/Providers/TADZKLib.php';
require 'tad/lib/Exceptions/ConnectionError.php';
require 'tad/lib/Exceptions/FilterArgumentError.php';
require 'tad/lib/Exceptions/UnrecognizedArgument.php';
require 'tad/lib/Exceptions/UnrecognizedCommand.php';
//header ("Content-Type:text/html");
$tad_factory = new TADPHP\TADFactory(['ip'=>'103.91.229.62']);
$tad = $tad_factory->get_instance();

//header("Content-type:application/json");



?>
