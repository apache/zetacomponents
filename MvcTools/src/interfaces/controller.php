<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Interface defining controller classes.
 * 
 * Controllers process the client's request and returns variables usable by the
 * view-manager in an instance of an ezcMvcResult.  Controllers should not
 * access request variables directly but should use the passed ezcMvcRequest.
 * The process is done through the createResult() method, but is not limited to
 * use protected nor private methods. The result of running a controller is an
 * instance of ezcMvcResult.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
abstract class ezcMvcController
{
    /**
     * Contains the action to run
     * @var string
     */
    protected $action;

    /**
     * Contains the original request
     * @var ezcMvcRequest
     */
    protected $request;

    /**
     * Creates a new controller object and sets all the request variables as class variables.
     *
     * @throws ezcMvcControllerException if the action method is empty
     * @param string        $action
     * @param ezcMvcRequest $request
     */
    public function __construct( $action, ezcMvcRequest $request )
    {
        if ( ezcBase::inDevMode() && ( !is_string( $action ) || strlen( $action ) == 0 ) )
        {
            throw new ezcMvcControllerException( "The '" . get_class( $this ) . "' controller requires an action." );
        }
        $this->action = $action;
        $this->setRequestVariables( $request );
    }

    /**
     * Loops over all the variables in the request, and sets them as object properties.
     *
     * @param ezcMvcRequest $request
     */
    protected function setRequestVariables( ezcMvcRequest $request )
    {
        foreach ( $request->variables as $key => $value )
        {
            $this->$key = $value;
        }
        $this->request = $request;
    }

    /**
     * Creates a method name to call from an action name.
     *
     * @return string
     */
    public static function createActionMethodName( $action )
    {
        $actionMethod = 'do' . preg_replace( '@[^A-Za-z]@', '', preg_replace( '@[A-Za-z]+@e', 'ucfirst( "\\0" )', $action ) );
        return $actionMethod;
    }

    /**
     * Runs the controller to process the query and return variables usable
     * to render the view. 
     * 
     * @throws ezcMvcActionNotFoundException if the action method could not be found
     * @return ezcMvcResult|ezcMvcInternalRedirect
     */
    public function createResult()
    {
        $actionMethod = $this->createActionMethodName( $this->action );

        if ( method_exists( $this, $actionMethod ) )
        {
            return $this->$actionMethod();
        }
        throw new ezcMvcActionNotFoundException( $this->action );
    }
}
?>
