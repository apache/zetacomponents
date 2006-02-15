<?php
/**
 * File containing the ezcDbSchemaException class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class provides exception for misc errors that may occur in the component,
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaException extends Exception
{
    /**
     * Unknown error
     */
    const GENERIC_ERROR = 0;

    /**
     * Invalid argument passed.
     */
    const INVALID_ARGUMENT = 1;

    /**
     * Unknown storage type
     */
    const UNKNOWN_STORAGE_TYPE = 2;

    /**
     * Unknown internal format
     */
    const UNKNOWN_INTERNAL_FORMAT = 3;

    /**
     * File does not exist
     */
    const FILE_NOT_FOUND = 4;

    /**
     * Construct exception object.
     *
     * @param int    $code    Error code: one of the constants defined
     *                        in ezcDbSchemaExceptions.
     * @param string $message Optional error message. If not specified,
     *                        then default message is used.
     */
    public function __construct( $code, $message = null )
    {
        if ( $message === null )
        {
            // If message is not specified, let's set the default one.
            switch ( $code )
            {
                case self::GENERIC_ERROR:
                    $message = 'Unknown error.';
                    break;

                case self::INVALID_ARGUMENT:
                    $message = 'Invalid argument.';
                    break;

                case self::UNKNOWN_STORAGE_TYPE:
                    $message = 'Unknown storage type.';
                    break;

                case self::UNKNOWN_INTERNAL_FORMAT:
                    $message = 'Unknown internal format.';
                    break;

                case self::FILE_NOT_FOUND:
                    $message = 'File not found.';
                    break;
            }
        }

        parent::__construct( $message, $code );
    }
}
?>
