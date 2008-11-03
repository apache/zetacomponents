<?php
/**
 * File containing the ezcMvcExternalRedirect class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This result type is used to force an external redirect
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcExternalRedirect extends ezcMvcResult
{
    /**
     * The location where to re-direct to.
     *
     * @var string
     */
    public $realm;

    /**
     * Constructs an ezcMvcExternalRedirect object to re-direct to $location
     *
     * @param string $location
     */
	public function __construct( $location )
	{
		$this->location = $location;
	}
}
?>
