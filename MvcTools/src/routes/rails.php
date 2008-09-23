<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Router class that uses rails style expressions for matching routes.
 *
 * The routes are matched against the uri property of the request object.
 * 
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcRailsRoute implements ezcMvcRoute
{
    /**
     * This property contains the pattern
     *
     * @var string
     */
    protected $pattern;

    /**
     * This is the name of the controller class that will be instantiated with
     * the request variables obtained from the route, as well as the default
     * values belonging to a route.
     *
     * @var string
     */
    protected $controllerClassName;

    /**
     * Contains the action that the controller should execute.
     *
     * @var string
     */
    protected $action;

    /**
     * The default values for the variables that are send to the controller.
     * The route matchers can override those default values
     *
     * @var array(string)
     */
    protected $defaultValues;

    /**
     * Constructs a new ezcMvcRailsRoute with $pattern.
     *
     * When the route is matched (with the match() method), the route
     * instantiates an object of the class $controllerClassName.
     *
     * @param string $pattern
     * @param string $controllerClassName
     * @param string $action
     * @param array(string) $defaultValues
     */
    public function __construct( $pattern, $controllerClassName, $action = null, array $defaultValues = array() )
    {
        $this->pattern = $pattern;
        $this->controllerClassName = $controllerClassName;
        $this->action = $action;
        $this->defaultValues = $defaultValues;
    }

    /**
     * Evaluates the URI against this route.
     *
     * The method first runs the match. If the pattern matches, it then creates
     * an object containing routing information and returns it. If the route's
     * pattern did not match it returns null.
     *
     * @param ezcMvcRequest $request
     * @return null|ezcMvcRoutingInformation
     */
    public function matches( ezcMvcRequest $request )
    {
        if ( $this->match( $request, $matches ) )
        {
            $request->variables = array_merge( $this->defaultValues, $request->variables, $matches );

            return new ezcMvcRoutingInformation( $this->pattern, $this->controllerClassName, $this->action );
        }
        return null;
    }

    /**
     * This method performs the actual pattern match against the $request's
     * URI.
     *
     * @param ezcMvcRequest $request
     * @param array(string) &$matches
     * @return bool
     */
    protected function match( $request, &$matches )
    {
        $matches = array();

        // first we split the pattern and request ID per /
        $patternParts = split( '/', $this->pattern );
        $requestParts = split( '/', $request->uri );

        // if the number of / is not the same, it can not match
        if ( count( $patternParts ) != count( $requestParts ) )
        {
            return false;
        }

        // now loop over all parts of the pattern, and see if it matches with
        // the request URI
        foreach ( $patternParts as $id => $patternPart )
        {
            if ( $patternPart == '' || $patternPart[0] != ':' )
            {
                if ( $patternPart !== $requestParts[$id] )
                {
                    return false;
                }
            }
            else
            {
                if ( $requestParts[$id] == '' )
                {
                    return false;
                }
                $matches[substr( $patternPart, 1 )] = $requestParts[$id];
            }
        }
        return true;
    }

    /**
     * Adds the $prefix to the route's pattern.
     *
     * It's up to the developer to provide a meaningfull prefix. In this case,
     * it needs to be a pattern just like the normal pattern.
     * 
     * @param mixed $prefix Prefix to add.
     * @return void
     */
    public function prefix( $prefix )
    {
        $this->pattern = $prefix . $this->pattern;
    }
}
?>
