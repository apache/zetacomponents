<?php
/**
 * File containing the ezcTemplateIfConditionTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Control structure: if.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateIfConditionTstNode extends ezcTemplateBlockTstNode
{
    public $name;
    public $condition;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;
    }

    public function getTreeProperties()
    {
        return array( 'name'      => $this->name,
                      'condition' => $this->condition,
                      'children'  => $this->children );
    }

    public function canHandleElement( ezcTemplateTstNode $element )
    {
        return (
            $element instanceof ezcTemplateIfConditionTstNode ||
            $element instanceof ezcTemplateLoopTstNode
        );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        $this->elements[] = $element;
        $element->parentBlock = $this;
    }
}
?>
