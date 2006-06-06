<?php
/**
 * File containing the ezcTemplatePrintAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a print construct.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplatePrintAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression to output when evaluated.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }

    /**
     * Validates the expression against its constraints.
     *
     * @throws Exception if the constraints are not met.
     * @todo Fix exception class
     */
    public function validate()
    {
        if ( $this->expression === null )
        {
            throw new Exception( "Missing expression for class <" . get_class( $this ) . ">." );
        }
    }
}
?>
