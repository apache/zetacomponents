<?php
require_once 'tutorial_autoload.php';

// create an ezcUrlConfiguration object
$urlCfg = new ezcUrlConfiguration();

// set default values for the configuration (parameters and delimiters)
$urlCfg->defaultConfiguration();
$urlCfg->basedir = 'mydir';
$urlCfg->script = 'index.php';

// visualize the $urlCfg object
var_dump( $urlCfg );

// create a new ezcUrl object from a string url and use the above $urlCfg
$url = new ezcUrl( 'http://www.example.com/mydir/index.php/doc/components/view/trunk', $urlCfg );

?>

