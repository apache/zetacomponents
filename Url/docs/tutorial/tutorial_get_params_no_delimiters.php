<?php
require_once 'tutorial_autoload.php';

// create an ezcUrlConfiguration object
$urlCfg = new ezcUrlConfiguration();

$urlCfg->basedir = '/mydir/shop';
$urlCfg->script = 'index.php';
$urlCfg->addOrderedParameter( 'module' );

$url = new ezcUrl( 'http://www.example.com/mydir/shop/index.php/order/Software/PHP/Version/5.2/Extension/XDebug/Extension/openssl', $urlCfg );

// get the unordered parameters as a flat array
var_dump( $url->getParams() ); // will output array( 'Software', 'PHP', 'Version', '5.2', 'Extension', 'XDebug', 'Extension', 'openssl' )
?>
