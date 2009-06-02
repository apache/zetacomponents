<?php
/**
 * Missing document visitor exception
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when a visitor could not be found for a node / subtree.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentMissingVisitorException extends ezcDocumentException
{
    /**
     * Construct exception from errnous string and current position
     *
     * @param string $class
     * @return void
     */
    public function __construct( $class, $line = 0, $position = 0 )
    {
        parent::__construct(
            "Could not find visitor for '{$class}' at {$line}, {$position}."
        );
    }
}

?>
