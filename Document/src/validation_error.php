<?php
/**
 * File containing the ezcDocumentXmlBase class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Wrapper for DOM error structures, encapsulating document validation errors.
 * Implementing a __toString method for the error messages.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentValidationError
{
    /**
     * Original LibXMLError.
     * 
     * @var LibXMLError
     */
    protected $error;

    /**
     * textual mapping for libxml error types.
     * 
     * @var array
     */
    protected $errorTypes = array(
        LIBXML_ERR_WARNING => 'Warning',
        LIBXML_ERR_ERROR   => 'Error',
        LIBXML_ERR_FATAL   => 'Fatal error',
    );

    /**
     * Create validation error from LibXMLError
     * 
     * @param LibXMLError $error 
     * @return void
     */
    public function __construct( LibXMLError $error )
    {
        $this->error = $error;
    }

    /**
     * Get original libXml error object
     * 
     * @return LibXMLError
     */
    public function getLibXmlError()
    {
        return $this->error;
    }

    /**
     * Convert libXML error to string
     * 
     * @return void
     */
    public function __toString()
    {
        return sprintf( "%s in %d:%d: %s.",
            $this->errorTypes[$this->error->level],
            $this->error->line,
            $this->error->column,
            trim( $this->error->message )
        );
    }
}

?>
