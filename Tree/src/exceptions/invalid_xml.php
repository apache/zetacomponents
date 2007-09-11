<?php
/**
 * File containing the ezcTreeInvalidXmlException class.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when an XML tree document is not well-formed.
 *
 * @package Tree
 * @version //autogen//
 */
class ezcTreeInvalidXmlException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeInvalidXmlException.
     *
     * @param string $xmlFile
     * @param array $errors
     */
    public function __construct( $xmlFile, array $errors )
    {
        $message = '';
        foreach( $errors as $error )
        {
            $message .= sprintf( "%s:%d:%d: %s\n", $error->file, $error->line, $error->column, trim( $error->message ) );
        }
        parent::__construct( "The XML file '$xmlFile' is not well-formed:\n". $message );
    }
}
?>
