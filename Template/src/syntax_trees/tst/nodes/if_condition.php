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
 * Control structure: foreach.
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

    /**
     *
     * @retval ezcTemplateAstNode
     * @todo Not implemented yet.
     */
    public function transform()
    {
    }

    public function symbol()
    {
        if ( $this->name == 'if' )
        {
            $c = $this->condition;
            $text = "if $c";
        }
        else
            $text = "else";

        return $text;
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
