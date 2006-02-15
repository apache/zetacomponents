<?php
/**
 * File containing the ezcTemplateSourceToTstParserException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for failed element parsers.
 * The exception will display the exact location(s) where the error occured
 * with some extra description of what went wrong.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateSourceToTstParserException extends Exception
{
    /**
     * The object containing the error details.
     * @var ezcTemplateParserError
     */
    public $parserError;

    /**
     * Initialises the exception with the parser error object and sets the
     * exception message from it.
     *
     * @param ezcTemplateParserError $error The object containing error details.
     */
    public function __construct( ezcTemplateParserError $error )
    {
        $this->parserError = $error;

        parent::__construct( $error->getErrorMessage() );
    }

}
?>
