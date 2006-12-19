<?php
// All errors must be reported
error_reporting( E_ALL | E_STRICT );

ini_set( 'include_path', getcwd(). PATH_SEPARATOR . dirname( __FILE__ ) . '/../..' . PATH_SEPARATOR . ini_get( 'include_path' ) );

require_once("Base/src/base.php");

function __autoload( $className )
{
    if ( strpos( $className, "_" ) !== false )
    {
        $file = str_replace( "_", "/", $className ) . ".php";
        $val = require_once( $file );
        if ( $val == 0 )
            return true;
        return false;
    }
    ezcBase::autoload( $className );
}

ezcTestRunner::addFileToFilter( __FILE__ );
ezcTestRunner::main();
?>
