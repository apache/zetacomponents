<?php
/**
 * File containing the ezcTemplateForeachLoopTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Control structure: foreach.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateForeachLoopTstNode extends ezcTemplateBlockTstNode
{
    public $array;
    public $keyVariableName;
    public $itemVariableName;
    public $value;

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
    }

    public function getTreeProperties()
    {
        return array( 'name'             => $this->name,
                      'isClosingBlock'   => $this->isClosingBlock,
                      'isNestingBlock'   => $this->isNestingBlock,
                      'array'            => $this->array,
                      'keyVariableName'  => $this->keyVariableName,
                      'itemVariableName' => $this->itemVariableName,
                      'value'            => $this->value,
                      'children'         => $this->children );
    }

    /**
     *
     * @retval ezcTemplateAstNode
     * @todo Not implemented yet.
     */
    public function transform()
    {
    }

    public function canHandleElement( ezcTemplateTstNode $element )
    {
        return ( $element instanceof ezcTemplateLoopTstNode && $element->name != 'delimiter' );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        $this->elements[] = $element;
        $element->parentBlock = $this;
    }
}
?>
