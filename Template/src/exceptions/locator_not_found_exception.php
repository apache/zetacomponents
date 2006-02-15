<?php
/**
 * File containing the ezcTemplateLocatorNotFoundException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for missing locator handlers in the template manager. The tried
 * location object is passed to the constructor.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateLocatorNotFoundException extends Exception
{

    /**
     * Initialises the exception with the location object $location which
     * contains the locator which is missing.
     *
     * @param string $locator The ezcTemplateLocation object.
     */
    public function __construct( ezcTemplateLocation $location )
    {
        parent::__construct( "The requested template location <{$location->locationString()}> could not be processed, the locator <{$location->locator}> was not found in the manager." );
    }

}
?>
