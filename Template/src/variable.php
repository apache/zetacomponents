<?php
/**
 * File containing the ezcTemplateVariable class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Encapsulates the required data for a template variable.
 *
 * The variable is stored with a unique name, value and direction. In addition it
 * can contain a type hint which may be used by the template to further optimize
 * the code.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateVariable
{

    /**
     * Variable is passed from caller (PHP code or template code) to template code.
     * @var int
     */
    const DIR_IN = 1;

    /**
     * Variable is passed from template code to caller (PHP code  or template code).
     * This means that template code can set this variable and it will be readable by
     * PHP code after execution.
     * @var int
     */
    const DIR_OUT = 2;

    /**
     * Variable is not passed from one template to another but only contains a value
     * for use ine one template.
     * @var int
     */
    const DIR_NONE = 3;

    /**
     * The name of the variable which must be a non-empty string.
     * @var string
     */
    public $name;

    /**
     * The value of the variable.
     *
     * Note: The null type cannot be used as value since it is used to determine if
     * the variable is initialised or not.
     * @var mixed
     */
    public $value = null;

    /**
     * The class name or name of basic type the variable can contain. This can be
     * used as type-hint for the template optimizer. If there is no specific type it
     * must contain null.
     *
     * Note: A variable value of null is allowed for any given type.
     * @var string
     */
    public $type = null;

    /**
     * Controls passing direction of the variable, e.g. if it used as input (DIR_IN),
     * output (DIR_OUT) or normal variable (DIR_NONE).
     * @var int
     */
    public $direction = self::DIR_NONE;

    /**
     * Initialises the properties from the parameters.
     *
     * @param string $name The name of the variable.
     * @param mixed $value The value for the variable.
     * @param string $type A type-hint for the variable which can be used by the
     * optimizer.
     * @param int $direction The direction passing for the variable.
     */
    public function __construct( $name, $value = null, $type = null, $direction = ezcTemplateVariable::DIR_NONE )
    {
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
        $this->direction = $direction;
    }

}
?>
