<?php
/**
 * File containing the ezcArchiveValueException class
 * 
 * @package Archive
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Archive value is wrong.
 * 
 * @package Archive
 * @author
 * @version //autogen//
 */
class ezcArchiveValueException extends ezcArchiveException
{
    /**
     * Construct an archive exception.
     *
     * @param string $message
     * @param int $code
     */
    function __construct( $value, $expectedValue = null )
    {
        $type = gettype( $value );
        if ( in_array( $type, array( 'array', 'object', 'resource' ) ) )
        {
            $value = serialize( $value );
        }
        
        $msg = "The value <$value> is incorrect.";
        if ( $expectedValue )
        {
            $msg .= " Allowed values are: " . $expectedValue . '.';
        }
        parent::__construct( $msg );
    }
}
?>
