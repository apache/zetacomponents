<?php
/**
 * File containing the ezcTemplateCaseAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a case control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCaseAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression to use as case match.
     * @var ezcTemplateAstNode
     */
    public $match;

    /**
     * The body element for the case statement.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $match = null, ezcTemplateBodyAstNode $body = null )
    {
        parent::__construct();
        $this->match = $match;
        $this->body = $body;
    }

    /**
     * Returns the match and body of this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array( $this->match, $this->body );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "case";
    }

    /**
     * @inheritdocs
     * Calls visitCaseControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->match === null )
        {
            throw new Exception( "Case control element does not have the \$match variable set." );
        }
        if ( $this->body === null )
        {
            throw new Exception( "Case control element does not have the \$body variable set." );
        }
        $visitor->visitCaseControl( $this );
    }
}
?>
