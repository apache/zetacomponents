<?php
/**
 * File containing the ezcTemplateVariableAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents PHP variables.
 *
 * Variables consists of a string which defines the name of the variable
 * to access.
 *
 * Normal lookup of variable named $some_var.
 * <code>
 * $var = new ezcTemplateVariableAstNode( 'some_var' );
 * </code>
 * The corresponding PHP code will be:
 * <code>
 * $some_var
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateVariableAstNode extends ezcTemplateAstNode
{
    /**
     * The name of the variable.
     */
    public $name;

    /**
     * @param string $name The name of the variable.
     */
    public function __construct( $name )
    {
        parent::__construct();
        if ( !is_string( $name ) )
        {
            throw new ezcBaseValueException( "name", $name, 'string' );
        }
        $this->name = $name;
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
        return "variable <{$this->name}>";
    }

    /**
     * @inheritdocs
     * Calls visitVariable() for ezcTemplateBasicAstNodeVisitor interfaces.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitVariable( $this );
    }

}
?>
