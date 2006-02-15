<?php
/**
 * File containing the ezcHttpException class.
 *
 * @package Http
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class provides exception for misc errors that may occur in the component.
 *
 * @package Http
 */
class ezcHttpException extends Exception
{
    /**
     * A custom error.
     *
     * You will probably want to specify your error message
     * when throwing exception of this type.
     * In this case use the second parameter for the constructor.
     */
    const GENERIC_ERROR = 0;

    /**
     * Functionality is not implemented.
     */
    const NOT_IMPLEMENTED = 1;

    /**
     * Invalid argument passed to a method.
     */
    const INVALID_ARGUMENT = 2;

    /**
     * File not found.
     */
    const FILE_NOT_FOUND = 3;

    public function __construct( $code, $message = null )
    {
        if ( $message === null )
        {
            // If message is not specified, let's set the default one.
            switch ( $code )
            {
                case self::GENERIC_ERROR:
                    $message = 'Unknown error occured.';
                    break;

                case self::NOT_IMPLEMENTED:
                    $message = 'Functionality is not implemented. This probably means that you should override the method that threw the exception.';
                    break;

                case self::INVALID_ARGUMENT:
                    $message = 'Invalid argument.';
                    break;

                case self::FILE_NOT_FOUND:
                    $message = 'File not found.';

               default:
                    $message = '';
            }
        }

        parent::__construct( $message, $code );
    }
}
?>
