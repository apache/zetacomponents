<?php
/**
 * Document visitor exception
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
class ezcDocumentVisitException extends ezcDocumentException
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
            E_NOTICE  => 'Notice',
            E_WARNING => 'Warning',
            E_ERROR   => 'Error',
            E_PARSE   => 'Fatal error',
        );

        parent::__construct(
            sprintf( "Visitor error: %s: '%s' in line %d at position %d.",
                $levelMapping[$level],
                $message,
                $line,
                $position
            )
        );
    }
}

?>
