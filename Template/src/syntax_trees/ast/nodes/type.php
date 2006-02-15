<?php
/**
 * File containing the ezcTemplateTypeAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents PHP builtin types.
 *
 * Creating the type is done by simply passing the type to the constructor
 * which will take care of storing it and exporting it to PHP code later on.
 * The following types can be added:
 * - integer
 * - float
 * - boolean
 * - null
 * - string
 * - array
 * - objects
 *
 * The following types are not supported:
 * - resource
 *
 * @note Objects will have to implement the __set_state magic method to be
 *       properly exported.
 *
 * <code>
 * $tInt = new ezcTemplateTypeAstNode( 5 );
 * $tFloat = new ezcTemplateTypeAstNode( 5.2 );
 * $tString = new ezcTemplateTypeAstNode( "a simple string" );
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTypeAstNode extends ezcTemplateAstNode
{
    /**
     * The constant value for the type.
     */
    public $value;

    /**
     * @param mixed $value The value of PHP type to be stored in code element.
     * @todo Fix exception class + doc for it
     */
    public function __construct( $value )
    {
        parent::__construct();

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
    }

    /**
     * Returns an empty array.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array();
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        if ( is_int( $this->value ) )
            return "integer <{$this->value}>";

        if ( is_float( $this->value ) )
            return "float <{$this->value}>";

        if ( is_bool( $this->value ) )
            return "boolean <" . ( $this->value ? "true" : "false" ) . ">";

        if ( is_null( $this->value ) )
            return "null <>";

        if ( is_string( $this->value ) )
            return "string <" . var_export( $this->value, true ) . ">";

        if ( is_array( $this->value ) )
            return "array <" . var_export( $this->value, true ) . ">";

        if ( is_object( $this->value ) )
            return "object <" . var_export( $this->value, true ) . ">";
    }

    /**
     * @inheritdocs
     * Calls visitType() for ezcTemplateBasicAstNodeVisitor interfaces.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitType( $this );
    }

}
?>
