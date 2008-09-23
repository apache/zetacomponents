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
     * @param ezcMvcRequest $request
     */
    public function __construct( $action, ezcMvcRequest $request )
    {
        foreach ( $request->variables as $key => $value )
        {
            $this->$key = $value;
        }
        $this->request = $request;
        $this->action = $action;
    }

    /**
     * Runs the controller to process the query and return variables usable
     * to render the view. 
     * 
     * @return ezcMvcResult|ezcMvcInternalRedirect
     */
    public function createResult()
    {
        $actionMethod = 'do' . preg_replace( '@\W@', '', preg_replace( '@\w+@e', 'ucfirst( "\\0" )', $this->action ) );

        if ( method_exists( $this, $actionMethod ) )
        {
            return $this->$actionMethod();
        }
        throw new ezcMvcActionNotFoundException( $this->action );
    }
}
?>
