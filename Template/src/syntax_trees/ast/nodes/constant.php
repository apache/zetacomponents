<?php
/**
 * File containing the ezcTemplateConstantAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents PHP constants.
 *
 * Creating the type is done by simply passing the constant name to the
 * constructor which will take care of storing it and exporting it to PHP
 * code later on.
 *
 * <code>
 * $c = new ezcTemplateConstantAstNode( 'E_NOTICE' );
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateConstantAstNode extends ezcTemplateAstNode
{
    /**
     * The value for the constant.
     */
    public $value;

    /**
     * @param mixed $value The value of constant.
     */
    public function __construct( $value )
    {
        parent::__construct();
        $this->value = $value;
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
        return "constant <{$this->value}>";
    }

    /**
     * @inheritdocs
     * Calls visitConstant() for ezcTemplateBasicAstNodeVisitor interfaces.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitConstant( $this );
    }

}
?>
