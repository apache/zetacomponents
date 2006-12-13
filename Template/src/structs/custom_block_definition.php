<?php
/**
 * File containing the ezcTemplateCustomBlockDefinition class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Contains the definition of a custom block.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateCustomBlockDefinition extends ezcTemplateCustomExtension
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
     * Specifies whether the class has an open and close tag or only a open tag.
     *
     * @var bool
     */
    public $hasCloseTag;

    /**
     * Holds the first parameter of a custom block without a name.
     *
     * If the custom block should have a start expression then this variable
     * specifies a name for it. The name should reappear in either the
     * {@link optionalParameters} or the {@link requiredParameters}.
     *
     * @var string
     */
    public $startExpressionName;

    /**
     * Holds the optional named parameters for this custom block.
     *
     * @var array(string)
     */
    public $optionalParameters = array();

    /**
     * Holds the required named parameters for this custom block.
     *
     * @var array(string)
     */
    public $requiredParameters = array();
}
?>
