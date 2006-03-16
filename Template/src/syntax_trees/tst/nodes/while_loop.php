<?php
/**
 * File containing the ezcTemplateWhileLoopTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Control structures: while, do..while.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateWhileLoopTstNode extends ezcTemplateBlockTstNode
{
    public $condition;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end, $name = null )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;
        $this->name = $name;
    }

    public function getTreeProperties()
    {
        return array( 'name'      => $this->name,
                      'condition' => $this->condition,
                      'children'  => $this->children );
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

    /**
     * Saves the do..while condition in the open block.
     *
     * @param ezcTemplateBlockTstNode $openBlock The block which is currently open.
     */
    public function closeOpenBlock( ezcTemplateBlockTstNode $openBlock )
    {
        if ( $this->name == 'do' )
            $openBlock->condition = $this->condition;
    }

}
?>
