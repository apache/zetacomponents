<?php
/**
 * File containing the ezcDocumentVisitException class.
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when the RST visitor could not visit an AST node
 * properly.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentInvalidFontException extends ezcDocumentException
{
    /**
     * Construct exception from errnous string and current position
     *
     * @param string $font
     * @return void
     */
    public function __construct( $font )
    {
        parent::__construct(
            sprintf( "Unknown font '%s' - cannot be rendered. Try to register the font using @font-face.",
                $font
            )
        );
    }
}

?>
