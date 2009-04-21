<?php
/**
 * Document conversion exception
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
    public function __construct( $level, $message, $file = null, $line = null, $position = null )
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
