<?php
/**
 * File containing the ezcTreeInvalidXmlFormatException class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when an XML tree document does not validate.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeInvalidXmlFormatException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidXmlFormatException.
     *
     * @param string $xmlFile
     * @param array $errors
     */
    public function __construct( $xmlFile, $errors )
    {
        $message = '';
        foreach( $errors as $error )
        {
            $message .= sprintf( "%s:%d:%d: %s\n", $error->file, $error->line, $error->column, trim( $error->message ) );
        }
        parent::__construct( "The XML file '$xmlFile' does not validate according to the expected schema:\n". $message );
    }
}
?>
