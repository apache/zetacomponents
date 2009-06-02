<?php
/**
 * Erroneous XML exception
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * General exception container for the Document component.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentErroneousXmlException extends ezcDocumentException
{
    /**
     * Errors occured during parsing process
     *
     * @var array
     */
    protected $errors;

    /**
     * Construct exception from array with XML errors
     *
     * @param array $errors
     * @return void
     */
    public function __construct( array $errors )
    {
        $this->errors = $errors;
        parent::__construct( "Errors occured while parsing the XML." );
    }

    /**
     * Return array with XML errors
     *
     * @return array
     */
    public function getXmlErrors()
    {
        return $this->errors;
    }
}

?>
