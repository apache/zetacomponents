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
     * Type rule defined for parameter not met.
     */
    const CODE_TYPE      = -12;

    /**
     * Parameter this exception is about.
     * Shortcut name of the parameter this exception deals with.
     *
     * @see ezcConsoleParameter::registerParam()
     *
     * @var string
     */
    public $param;
    
    public function __construct( $message, $param, $code = -10 ) {
        $this->param = $param;
        parent::__construct( $message, $code );
    }
}
