<?php
/**
 * File containing the ezcDocumentInvalidDocbookException class.
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown if an expectation to an incoming DocBook document is not 
 * met.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentInvalidDocbookException extends ezcDocumentException
{
    /**
     * Creates a new exception.
     * 
     * @param DOMNode $affectedNode 
     * @param string $message 
     */
    public function __construct( DOMNode $affectedNode, $message )
    {
        parent::__construct(
            "The DocBook node {$node->localName} was invalid: $message"
        );
    }
}

?>
