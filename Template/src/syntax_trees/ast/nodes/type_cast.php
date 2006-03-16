<?php
/**
 * File containing the ezcTemplateTypeCastAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTypeCastAstNode extends ezcTemplateAstNode
{
    /**
     * The constant type.
     */
    public $type;

    public $value;

    /**
     */
    public function __construct( $castToType, $value )
    {
        parent::__construct();

        // TODO, check for int, string, array, etc.

        $this->type = $castToType;
        $this->value = $value;
    }

    /**
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {

        return array( $this->value );
        //return $this->value;
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "type_cast (".$this->type.")";
    }

    /**
     * @inheritdocs
     * Calls visitType() for ezcTemplateBasicAstNodeVisitor interfaces.
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitTypeCast( $this );
    }

}
?>
