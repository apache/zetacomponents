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
class ezcDocumentConversionException extends ezcDocumentException
{
    /**
     * Mapping of error levels to strings
     * 
     * @var array
     */
    protected $levelMapping = array(
        E_NOTICE  => 'Notice',
        E_WARNING => 'Warning',
        E_ERROR   => 'Error',
        E_PARSE   => 'Fatal error',
    );

    /**
     * Error string
     *
     * String describing the general type of this error
     * 
     * @var string
     */
    protected $errorString = 'Conversion error';

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
        parent::__construct( 
            sprintf( "%s: %s: '%s' in line %d at position %d.",
                $this->errorString,
                $this->levelMapping[$level],
                $message,
                $line,
                $position
            )
        );
    }
}

?>
