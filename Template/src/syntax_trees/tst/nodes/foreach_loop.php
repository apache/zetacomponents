<?php
/**
 * File containing the ezcTemplateForeachLoopTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Control structure: foreach.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateForeachLoopTstNode extends ezcTemplateBlockTstNode
{
    public $array;
    public $keyVariableName;
    public $itemVariableName;
    public $value;

    public $increment;
    public $decrement;
    public $offset;
    public $limit;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->value = $this->keyVariableName = $this->itemVariableName = null;
        $this->name = 'foreach';

        $this->increment = array();
        $this->decrement = array();

        $this->offset = $this->limit = null;
    }

    public function getTreeProperties()
    {
        return array( 'name'             => $this->name,
                      'isClosingBlock'   => $this->isClosingBlock,
                      'isNestingBlock'   => $this->isNestingBlock,
                      'array'            => $this->array,
                      'keyVariableName'  => $this->keyVariableName,
                      'itemVariableName' => $this->itemVariableName,
                      'increment'        => $this->increment,
                      'decrement'        => $this->decrement,
                      'value'            => $this->value,
                      'children'         => $this->children );
    }

    public function canHandleElement( ezcTemplateTstNode $element )
    {
        // return ( $element instanceof ezcTemplateLoopTstNode && $element->name != 'delimiter' );
        return false;
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        // Also accept the Delimiter TSTNode.
        $this->children[] = $element;

        // temporary compatability
        $this->elements = $this->children;

    }
}
?>
