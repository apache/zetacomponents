<?php
/**
 * File containing the ezcTemplateBodyAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a body consisting of statements.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateBodyAstNode extends ezcTemplateAstNode
{
    /**
     * Array of statements which make up the body.
     * @var array(ezcTemplateStatementAstNode)
     */
    public $statements;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( Array $statements = null )
    {
        parent::__construct();
        $this->statements = array();

        if ( $statements !== null )
        {
            foreach ( $statements as $statement )
            {
                if ( !$statement instanceof ezcTemplateStatementAstNode )
                {
                    throw new Exception( "Body code element can only use objects of instance ezcTemplateStatementAstNode as statements" );
                }
            }
            $this->statements = $statements;
        }
    }

    /**
     * Appends the statement to the current list of statements.
     *
     * @param ezcTemplateStatementAstNode $statement Statement object to append.
     */
    public function appendStatement( ezcTemplateStatementAstNode $statement )
    {
        $this->statements[] = $statement;
    }

    /**
     * Returns the last statement object from the body.
     * If there are no statements in the body it returns null.
     *
     * @return ezcTemplateStatementAstNode
     */
    public function getLastStatement()
    {
        $count = count( $this->statements );
        if ( $count === 0 )
        {
            return null;
        }
        return $this->statements[$count - 1];
    }

    /**
     * Returns the statements which makes up the body.
     *
     * @note The values returned from this method must never be modified.
     * @return array(ezcTemplateAstNode)
     */
    public function getSubElements()
    {
        return $this->statements;
    }

    /**
     * @inheritdocs
     */
    public function getRepresentation()
    {
        return "body";
    }

    /**
     * @inheritdocs
     * Calls visitBody() of the ezcTemplateBasicAstNodeVisitor interface.
     * @todo Fix exception class
     */
    public function accept( ezcTemplateAstNodeVisitor $visitor )
    {
        $visitor->visitBody( $this );
    }
}
?>
