<?php
/**
 * File containing the ezcTemplateLiteralArrayAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateLiteralArrayAstNode extends ezcTemplateAstNode
{
    /**
     * The constant value for the type.
     */
    public $value;

    public function checkAndSetTypeHint()
    {
        $this->typeHint = ezcTemplateAstNode::TYPE_ARRAY;
    }

    /**
     * @param mixed $value The value of PHP type to be stored in code element.
     * @todo Fix exception class + doc for it
     */
    public function __construct( )
    {
        parent::__construct();

        /*
        $this->value = $value;
        if ( is_resource( $value ) )
        {
            throw new Exception( "Cannot use resource for type codes, resources cannot be exported as text strings" );
        }

        // Check if the __set_state magic method is implemented
        if ( is_object( $value ) &&
             !method_exists( $value, "__set_state" ) )
        {
            throw new Exception( "The magic method __set_state is not implemented for passed object, the type code cannot create a representation of the object without it." );
        }
         */

        $this->checkAndSetTypeHint();
    }
}
?>
