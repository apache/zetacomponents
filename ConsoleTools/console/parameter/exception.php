<?php
/**
 * File containing the ezcConsoleParameterException class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * General exception for use in {@see ezcConsoleParameter} class.
 * Adds an additional field 'param' to the exception which indicates
 * with which parameter something went wrong.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleParameterException extends Exception
{

    /**
     * Required parameter/alias does not exist.
     */
    const CODE_EXISTANCE = -10;
    /**
     * Exclusion rule defined for parameter not met.
     */
    const CODE_EXCLUSION = -11;
    /**
     * Dependency rule defined for parameter not met.
     */
    const CODE_DEPENDENCY = -12;
    /**
     * Type rule defined for parameter not met.
     */
    const CODE_TYPE      = -13;

    /**
     * Parameter this exception is about.
     * Shortcut name of the parameter this exception deals with.
     *
     * @see ezcConsoleParameter::registerParam()
     *
     * @var string
     */
    public $paramName;
    
    /**
     * Constructor
     * The constructor additionally needs a parameter name, which is
     * the shortcut name of the affected parameter.
     * For error codes, see class constants!
     *
     * @param string string $message   Error message.
     * @param string string $paramName Name of affected parameter
     * @param int $code                Error code.
     */
    public function __construct( $message, $paramName, $code = -10 ) {
        $this->paramName = $paramName;
        parent::__construct( $message, $code );
    }
}
