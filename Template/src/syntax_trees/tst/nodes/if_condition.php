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
        if( $element instanceof ezcTemplateIfConditionTstNode )
        {
            if( $element->name == "if" ) 
            {
                return false;
            }

            echo "NAME: " . $element->name;
            return true;
        }

        return ( $element instanceof ezcTemplateLoopTstNode );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        $last = sizeof( $this->children ) - 1;

        if( !$element instanceof ezcTemplateConditionBodyTstNode )
        {
            $this->children[$last]->children[] = $element;
            //var_dump ($this->children[$last]->children );
        }
        else
        {
            $this->children[] = $element;
        }

        /*

        if( $this->canHandleElement( $element ) )
        {
            $this->elements[] = $element;
            $element->parentBlock = $this;
            $element->isNestingBlock = false;
        }
        else
        {
            parent::handleElement( $element );
        }
        */


    }
}
?>
