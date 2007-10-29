<?php

require_once dirname( __FILE__ ) . '/../../../Base/src/base.php';

function __autoload( $class )
{
    ezcBase::autoload( $class );
}

var_dump( unserialize( file_get_contents( $argv[1] ) ) );
echo "\n";
?>
