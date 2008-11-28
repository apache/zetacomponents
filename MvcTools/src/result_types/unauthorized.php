<?php
/**
 * File containing the ezcMvcResultUnauthorized class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This result type is used to signal a HTTP basic auth header
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcResultUnauthorized extends ezcBaseStruct
{
    /**
     * The realm is the unique ID to identify a login area
     *
     * @var string
     */
    public $realm;

    /**
     * Constructs an ezcMvcResultUnauthorized object for $realm
     *
     * @param string $realm
     */
    public function __construct( $realm )
    {
        $this->realm = $realm;
    }
}
?>
