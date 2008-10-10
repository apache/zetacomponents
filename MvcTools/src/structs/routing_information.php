<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ezcMvcTools
 */

/**
 * This struct contains information from the router that belongs to the matched
 * route.
 *
 * @package ezcMvcTools
 * @version //autogentag//
 */
class ezcMvcRoutingInformation extends ezcBaseStruct
{
    /**
     * Contains the pattern of the matched route, to be used for view matching
     * and filter chain selection.
     *
     * @var string
     */
    public $matchedRoute;

    /**
     * Contains the class name of the controller that should be instantiated
     * for this route.
     *
     * @var string
     */
    public $controllerClass;

    /**
     * Contains the action that the controller should run.
     *
     * @var string
     */
    public $action;

    /**
     * Constructs a new ezcMvcRoutingInformation.
     *
     * @param string $matchedRoute
     * @param string $controllerClass
     * @param string $action
     */
    public function __construct( $matchedRoute = '', $controllerClass = '', $action = '' )
    {
        $this->matchedRoute = $matchedRoute;
        $this->controllerClass = $controllerClass;
        $this->action = $action;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcMvcRoutingInformation
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRoutingInformation( $array['matchedRoute'], 
            $array['controllerClass'], $array['action'] );
    }
}
?>
