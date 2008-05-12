<?php
/**
 * Base exception for the Document package.
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when the RST parser could not parse asome token sequence.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentParserException extends ezcDocumentException
{
    /**
     * Construct exception from errnous string and current position
     * 
     * @param int $level 
     * @param string $message 
     * @param string $file 
     * @param int $line 
     * @param int $position 
     * @return void
     */
    public function __construct( $level, $message, $file, $line, $position )
    {
        $levelMapping = array(
            1 => 'Notice',
            2 => 'Warning',
            4 => 'Error',
            8 => 'Fatal error',
        );

        parent::__construct( 
            sprintf( "Parse error: %s: '%s' in line %d at position %d.",
                $levelMapping[$level],
                $message,
                $line,
                $position
            )
        );
    }
}

?>
