<?php
/**
 * File containing the ezcTemplateIfConditionTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Control structure: switch.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateSwitchTstNode extends ezcTemplateBlockTstNode
{
    public $condition;

    public $defaultCaseFound = false;

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
        die ("can handle element, who uses that? ");
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        if ( $element instanceof ezcTemplateCaseTstNode  )
        {
            if ( $element->conditions === null )
            {
                if ( $this->defaultCaseFound )
                {
                    throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_DEFAULT_DUPLICATE);
                }

                $this->defaultCaseFound = true;
            }
            elseif( $this->defaultCaseFound ) // Found a default case already..
            {
                throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_DEFAULT_LAST);
            }

            parent::handleElement( $element );
        }
        elseif( $element instanceof ezcTemplateDocCommentTstNode )
        {
            parent::handleElement( $element );
        }
        else
        {
            if ( $element instanceof ezcTemplateTextBlockTstNode )
            {
                // Only spaces, newlines and tabs?
                if ( preg_match( "#^\s*$#", $element->text) != 0 )
                {
                    // It's okay, but ignore it.
                    return;
                }
            }

            throw new ezcTemplateParserException( $element->source, $element->startCursor, $element->startCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CASE_STATEMENT );
        }
/*
// Comment blocks are allowed.
//        elseif( $element instanceof ezcTemplateTextBlockTstNode )
//        {
//        }
        elseif ( $element instanceof ezcTemplateCaseTstNode )
        {
        }
        */

//            parent::handleElement( $element );


        

       /* $last = sizeof( $this->children ) - 1;
        */
/*
        if ( !$element instanceof ezcTemplateConditionBodyTstNode )
        {
            $this->children[$last]->children[] = $element;
            // var_dump ($this->children[$last]->children );
        }
        else
        {
            $this->children[] = $element;
        }
        */

    }
}
?>
