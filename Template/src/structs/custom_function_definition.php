<?php
/**
 * File containing the ezcTemplateCustomFunctionDefinition class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Contains the definition of a custom function.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateCustomFunctionDefinition extends ezcTemplateCustomExtension
{
    /**
     * Holds the (static) class that implements the function to be executed.
     *
     * @var string
     */
    public $class;

    /**
     * Holds the (static) method that should be run.
     *
     * @var string
     */
    public $method;

    /**
     * Holds the required and optional named parameters for this custom function.
     *
     * The optional parameters should be specified after the required parameters.
     * - Required parameters are named strings.
     * - Optional parameters are named strings enclosed with square brackets.
     *
     * @var array(string)
     */
    public $parameters = array();
}
?>
