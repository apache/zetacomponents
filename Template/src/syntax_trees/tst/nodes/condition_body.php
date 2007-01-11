<?php
/**
 * File containing the ezcTemplateIfConditionTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Control structure: if.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateConditionBodyTstNode extends ezcTemplateBlockTstNode
{
    public $condition;

    /*
    // Array.
    public $body;
    */

    /**
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;

        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'condition' => $this->condition,
                      'children'  => $this->children );
    }

    public function canAttachToParent( $parentElement )
    {
        if ( !$parentElement instanceof ezcTemplateIfConditionTstNode )
        {
            if ( $parentElement instanceof ezcTemplateProgramTstNode )
            {
               throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
                   "{" . $this->name . "} can only be a child of an {if} block." );
            } 

            throw new ezcTemplateParserException( $this->source, $this->startCursor, $this->startCursor, 
               "The block {" . $this->name . "} cannot be a sub-block of {".$parentElement->name."}. {".$this->name."} can only be a child of an {if} block." );
        }
    }


}
?>
