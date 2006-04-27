<?php
/**
 * File containing the ezcTemplateLocation class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Struct which encapsulates the locator and stream string for a template request.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateLocation
{

    /**
     * The identifier of the locator handler (subclass of ezcTemplateSourceLocator).
     * @var string
     */
    public $locator;

    /**
     * The PHP stream defining the location of the source file.
     * @var string
     */
    public $stream;

    /**
     * Initialises the locator and stream string.
     */
    public function __construct( $locator, $stream )
    {
        $this->locator = $locator;
        $this->stream = $stream;
    }

    /**
     * Returns a location string which is created from the locator identifier and the stream path.
     */
    public function locationString()
    {
        return ( $this->locator !== false ? $this->locator . ':' : '' ) . $this->stream;
    }

}
?>
