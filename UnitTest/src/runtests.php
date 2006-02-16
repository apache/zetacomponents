<?php

// All errors must be reported
error_reporting( E_ALL | E_STRICT );
require_once("Base/src/base.php");

function __autoload( $class_name )
{
    if ( strpos( $class_name, "_" ) !== false )
    {
        $file = str_replace( "_", "/", $class_name ) . ".php";
        $val = require_once( $file );
        if ( $val == 0 )
            return true;
        return false;
    }
    ezcBase::autoload( $class_name );
}

// Remove this file name from the assertion trace.
require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

ezcTestRunner::main();

?>
