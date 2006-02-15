<?php
/**
 * File containing the ezcTemplateTryAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a try control structure.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTryAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The body element.
     * @var ezcTemplateBodyAstNode
     */
    public $body;

    /**
     * Array of catche statements which are placed after the try body.
     * @var array(ezcTemplateCatchAstNode)
     */
    public $catches;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateBodyAstNode $body = null, Array $catches = null )
    {
        parent::__construct();
        $this->body = $body;
        $this->catches = array();

        if ( $catches !== null )
        {
            foreach ( $catches as $id => $catch )
            {
                if ( !$catch instanceof ezcTemplateCatchAstNode )
                {
                     throw new ezcBaseValueException( "catches[$id]", $catch, 'ezcTemplateCatchAstNode' );
                }
                $this->catches[] = $catch;
            }
        }
    }

    /**
     * Returns the body and list of catche elements for this element.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return array_merge( array( $this->body ), $this->catches );
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "try";
    }

    /**
     * @inheritdocs
     * Calls visitTryControl() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        if ( $this->body === null )
        {
            throw new Exception( "Try control element does not have the \$body variable set." );
        }
        if ( count( $this->catches ) === 0 )
        {
            throw new Exception( "Try control element does not have any catch elements, at least one is required." );
        }
        $visitor->visitTryControl( $this );
    }
}
?>
