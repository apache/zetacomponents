<?php

require_once 'Base/trunk/src/base.php';

/**
 * Autoload ezc classes 
 * 
 * @param string $class_name 
 */
function __autoload( $class_name )
{
    if ( ezcBase::autoload( $class_name ) )
    {
        return;
    }
    if ( strpos( $class_name, '_' ) !== false )
    {
        $file = str_replace( '_', '/', $class_name ) . '.php';
        require_once( $file );
    }
}

?>
