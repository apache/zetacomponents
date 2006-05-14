<?php

require_once 'Base/src/base.php';

/**
 * Autoload ezc classes 
 * 
 * @param string $className 
 */
function __autoload( $className )
{
    if ( ezcBase::autoload( $className ) )
    {
        return;
    }
    if ( strpos( $className, '_' ) !== false )
    {
        $file = str_replace( '_', '/', $className ) . '.php';
        require_once( $file );
    }
}

?>
