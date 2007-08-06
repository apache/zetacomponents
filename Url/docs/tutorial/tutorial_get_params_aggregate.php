<?php
require_once 'tutorial_autoload.php';

// create an ezcUrlConfiguration object
$urlCfg = new ezcUrlConfiguration();

// single parameter value
$urlCfg->addUnorderedParameter( 'param1' );
$url = new ezcUrl( 'http://www.example.com/(param1)/x/(param1)/y/z', $urlCfg );
var_dump( $url->getParam( 'param1' ) ); // will output "y"

// multiple parameter values
$urlCfg->addUnorderedParameter( 'param1', ezcUrlConfiguration::MULTIPLE_ARGUMENTS );
$url = new ezcUrl( 'http://www.example.com/(param1)/x/(param1)/y/z', $urlCfg );
var_dump( $url->getParam( 'param1' ) ); // will output array( "y", "z" )

// multiple parameter values with aggregation
$urlCfg->addUnorderedParameter( 'param1', ezcUrlConfiguration::AGGREGATE_ARGUMENTS );
$url = new ezcUrl( 'http://www.example.com/(param1)/x/(param1)/y/z', $urlCfg );
var_dump( $url->getParam( 'param1' ) ); // will output array( array( "x" ), array( "y", "z" ) )

// output the url (it will be similar to the input url)
var_dump( $url->buildUrl() );
?>
