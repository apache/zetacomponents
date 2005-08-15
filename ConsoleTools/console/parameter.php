<?php
/**
 * File containing the ezcConsoleParameter class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Class for handling console parameters.
 * This class allows the complete handling of parameters submitted
 * to a console based application.
 *
 * <code>
 *
 * $paramHandler = new ezcConsoleParameter();
 * 
 * $help = array(
 *  'short' => 'Get help output.',
 *  'long'  => 'Retreive help on the usage of this command.',
 * );
 * $paramHandler->registerParam('h', 'help', $help);
 *
 * $file = array(
 *  'type'     => ezcConsoleParameter::TYPE_STRING
 *  'short'    => 'Process a file.',
 *  'long'     => 'Processes a single file.',
 *  'excludes' => array('d'),
 * )
 * $paramHandler->registerParam('f', 'file', $file);
 *
 * $dir = array(
 *  'type'     => ezcConsoleParameter::TYPE_STRING
 *  'short'    => 'Process a directory.',
 *  'long'     => 'Processes a complete directory.',
 *  'excludes' => array('f'),
 * )
 * $paramHandler->registerParam('d', 'dir', $dir);
 *
 * $paramHandler->registerAlias('d', 'directory', 'd');
 *
 * try {
 *      $paramHandler->processParams();
 * } catch (ezcConsoleParameterException $e) {
 *      if ($e->code === ezcConsoleParameterException::CODE_DEPENDENCY) {
 *          $consoleOut->outputText(
 *              'Parameter '.$e->paramName." may not occur here.\n", 'error'
 *          );
 *      }
 *      exit(1);
 * }
 *
 * </code>
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleParameter
{

    const TYPE_NONE     = 10;
    const TYPE_INT      = 11;
    const TYPE_STRING   = 12;

    private $paramDefs = array();

    private $paramValues = array();

    /**
     * Create parameter handler
     */
    public function __construct( ) {
        
    }

    /**
     * Register a new parameter.
     * Register a new parameter to be recognized by the parser. The short 
     * option is a single character, the long option can be any string 
     * containing [a-z-]+. Via the options array several options can be 
     * defined for a parameter:
     *
     * <code>
     * array(
     *  'type'      => TYPE_NONE,  // option does not expect a value by 
     *                             // default, use TYPE_* constants
     *  'default'   => null,       // no default value by default
     *  'multiple'  => false,      // are multiple values expected?
     *  'short'     => '',         // no short description by default
     *  'long'      => '',         // no help text by default
     *  'depends'   => array(),    // no depending options by default
     *  'excludes'  => array(),    // no excluded options by default
     *  'arguments' => true,       // are arguments allowed?
     * );
     * </code>
     *
     * Attention: Already existing parameter will be overwriten! If an 
     * already existing alias is attempted to be registered, the alias 
     * will be deleted and replaced by the new parameter.
     *
     * Parameter shortcuts may only contain one character and will be 
     * used in an application call using "-x <value>". Long parameter
     * versions will be used like "--long-parameter=<value>".
     *
     * A parameter can have no value (TYPE_NONE), an integer/string
     * value (TYPE_INT/TYPE_STRING) or multiple of those 
     * ('muliple' => true).
     *
     * A parameter can also include a rule that disallows arguments, when
     * it's used. Per default arguments are allowed and can be retrieved
     * using the {ezcConsoleParameter::getArguments()} method.
     *
     * @see ezcConsoleParameter::unregisterParam()
     *
     * @param string $short          Short parameter
     * @param string $long           Long version of parameter
     * @param array(string) $options See description
     *
     * @return void
     */
    public function registerParam( $short, $long, $options = array() ) {
        
    }

    /**
     * Register an alias to a parameter.
     * Registers a new alias for an existing parameter. Aliases may
     * then be used as if they were real parameters.
     *
     * @see ezcConsoleParameter::unregisterAlias()
     *
     * @param string $short    Shortcut of the alias
     * @param string $long     Long version of the alias
     * @param strung $refShort Reference to an existing param (short)
     *
     * @return void
     */
    public function registerAlias( $short, $long, $refShort ) {
        
    }

    /**
     * Remove a parameter to be no more supported.
     * Using this function you will remove a parameter. Depending on the second 
     * option dependencies to this parameter are handled. Per default, just 
     * all dependencies to that actual parameter are removed (false value). 
     * Setting it to true will completely unregister all parameters that depend 
     * on the current one.
     *
     * @see ezcConsoleParameter::registerParam()
     *
     * @param string $short Short option name for the parameter to be removed.
     * @param bool $deps    Handling of dependencies while unregistering. 
     *
     * @return void
     *
     * @throws ezcConsoleParameterException 
     *         If requesting a nonexistant parameter 
     *         {@link ezcConsoleParameterException::CODE_EXISTANCE}.
     */
    public function unregisterParam( $short, $deps = false ) {
        
    }
    
    /**
     * Remove an alias  to be no more supported.
     * Unregisteres an existing alias.
     *
     * @see ezcConsoleParameter::registerAlias()
     * 
     * @param string $short Short option name for the parameter to be removed.
     *
     * @return void
     *
     * @throws ezcConsoleParameterException 
     *         If requesting a nonexistant alias 
     *         {@link ezcConsoleParameterException::CODE_EXISTANCE}.
     */
    public function unregisterAlias( $short ) {
        
    }

    /**
     * Registeres parameters according to a string specification.
     * Accepts a string like used in eZ publis 3.x to define parameters and
     * registeres all parameters accordingly. String definitions look like
     * this:
     *
     * <code>
     * [s:|size:][u:|user:][a:|all:]
     * </code>
     *
     * This string will result in 3 parameters:
     * -s / --size
     * -u / --user
     * -a / --all
     *
     * @param string $paramDef Parameter definition string.
     * @throws ezcConsoleParameterException If string is not wellformed.
     */
    public function fromString( $paramDef ) {
        
    }

    /**
     * Process the input parameters.
     * Actually process the input parameters according to the actual settings.
     * 
     * Per default this method uses $argc and $argv for processing. You can 
     * override this setting with your own input, if necessary, using the
     * parameters of this method. (Attention, first argument is always the pro
     * gram name itself!)
     *
     * All exceptions thrown by this method contain an additional attribute "param"
     * which specifies the parameter on which the error occured.
     * 
     * @param array(int -> string) $args The arguments
     *
     * @throws ezcConsoleParameterDependecyException 
     *         If dependencies are unmet 
     *         {@link ezcConsoleParameterException::CODE_DEPENDENCY}.
     * @throws ezcConsoleParameterExclusionException 
     *         If exclusion rules are unmet 
     *         {@link ezcConsoleParameterException::CODE_EXCLUSION}.
     * @throws ezcConsoleParameterTypeException 
     *         If type rules are unmet 
     *         {@link ezcConsoleParameterException::CODE_TYPE}.
     * 
     * @see ezcConsoleParameterException
     */ 
    public function process( $args = null ) {
        
    }
    
    /**
     * Receive the data for a specific parameter.
     * Returns the data sumbitted for a specific parameter.
     *
     * @param string $short The parameter shortcut
     *
     * @return mixed String value of the parameter or false if not set.
     *
     * @throws ezcConsoleParameterException 
     *         If requesting a nonexistant parameter 
     *         {@link ezcConsoleParameterException::CODE_EXISTANCE}.
     */
    public function getParam( $short ) {
        
    }

    /**
     * Returns arguments provided to the program.
     * This method returns all arguments provided to a program in an
     * integer indexed array. Arguments are sorted in the way
     * they are submitted to the program. You can disable arguments
     * through the 'arguments' flag of a parameter, if you want
     * to disallow arguments.
     *
     * Arguments are either the last part of the program call (if the
     * last parameter is not a 'multiple' one) or divided via the '--'
     * method which is commonly used on Unix (if the last parameter
     * accepts multiple values this is required).
     *
     * @return array(int => string) Arguments.
     */
    public function getArguments( ) {
        
    }

    /**
     * Returns array of help info on parameters.
     * If given a parameter shortcut, returns an array of several 
     * help information:
     *
     * <code>
     * array(
     *  'short' => <string>,
     *  'long'  => <string>,
     *  'usage' => <string>, // Autogenerated from the rules for the parameter
     *  'alias' => <string>, // Info on the aliases of a parameter
     * );
     * </code>
     *
     * If no parameter shortcut given, returns an array of above described 
     * arrays with a key for every parameter shortcut defined.
     * 
     * @param string $short Short cut value of the parameter.
     * @return array(string) See description.
     * 
     * @throws ezcConsoleParameterException 
     *         If requesting a nonexistant parameter 
     *         {@link ezcConsoleParameterException::CODE_EXISTANCE}.
     */
    public function getHelp( $short = null ) {

    }

    /**
     * Returns string of help info on parameters.
     * If given a parameter shortcut, returns a string of help information:
     *
     * <code>
     * 
     * Usage: -<short> / --<long>= <type> <usageinfo>
     * <shortdesc>
     * <longdesc>
     * <dependencies> / <exclusions>
     *
     * </code>
     *
     * If not given a parameter shortcut, returns a string of global help information:
     *
     * <code>
     * 
     * Usage: [-<short>] [-<short>] ...
     * -<short> / --<long>  <type>  <default>   <shortdesc>
     * ...
     * 
     * </code>
     * 
     * @param string $short Shortcut of the parameter to get help text for.

     * @return string See description.
     * 
     * @throws ezcConsoleParameterException 
     *         If requesting a nonexistant parameter 
     *         {@link ezcConsoleParameterException::CODE_EXISTANCE}.
     */
    public function getHelpText( $short = null ) {
        
    }
}
