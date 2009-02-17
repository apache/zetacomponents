<?php
// load the normal ezc autoload mechanism with some tricks
require_once 'tutorial_autoload.php';

// add the location of the zend framework to the include path, this can of
course also be done in php.ini
ini_set( 'include_path', ini_get( 'include_path' ) . ':/home/derick/dev/ZendFramework-1.7.4-minimal/library' );

// define the autoload function that can load Zend framework classes
function zend_autoload( $className )
{
    if ( strpos( $className, '_' ) !== false )
    {
        $file = str_replace( '_', '/', $className ) . '.php';
        $val = require_once( $file );
        return ( $val == 0 );
    }
}

// reset the autoload stack, register the zend_autoload mechanism and
// re-register the original eZ Component's autoload() mechanism.
spl_autoload_register( 'zend_autoload' );
spl_autoload_register( '__autoload' );

// open the handler
$handler = new ezcSearchZendLuceneHandler( '/tmp/lucene' );
?>
