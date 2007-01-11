<?php
/**
 * File containing the ezcTemplateGenericStatementAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a function call.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateGenericStatementAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The expression making up the statement.
     * @var ezcTemplateAstNode
     */
    public $expression;

    /**
     * Flag for whether the statement should be terminated with a semicolon or not.
     * This is true by default and can be turned off e.g. when one the expression
     * is contains multiple sub-statements.
     * @var bool
     */
    public $terminateStatement;

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( ezcTemplateAstNode $expression = null, $terminateStatement = true )
    {
        parent::__construct();

        $this->expression = $expression;
        $this->terminateStatement = $terminateStatement;
    }
}
?>
