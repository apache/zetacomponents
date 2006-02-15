<?php
/**
 * File containing the ezcQueryException class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Base class for exceptions related to the SQL abstraction.
 *
 * @package Database
 */
class ezcQueryVariableParameterException extends ezcQueryException
{
    /**
     * Constructs a QueryInvalid exception with the type $type and the
     * additional information $message.
     *
     * @param string $type
     * @param string $additionalInfo
     */
    public function __construct( $method, $numProvided, $numExpected )
    {
        $expectedString ="$numExpected parameter";
        if ( $numExpected > 1 )
        {
            $expectedString .= 's';
        }

        $providedString = "none were provided";
        if ( $numProvided == 1 )
        {
            $providedString = "only one was provided";
        }
        else if ( $numProvided > 1 )
        {
            $providedString = "only $numProvided was provided";
        }
        $info = "The method $method expected at least {$expectedString} but {$providedString}.";
        parent::__construct( $info );
    }
}
?>
