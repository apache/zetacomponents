<?php
/**
 * File containing the ezcTemplateConditionalOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class representing a conditional expression (?:).
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateConditionalOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end,
                             2, 1, self::LEFT_ASSOCIATIVE,
                             '?' );
        // This can have three parameters, the first is the condition
        // and the second and third is the expression for when the condition is
        // true or false.
        $this->maxParameterCount = 3;
    }

    /**
     * Returns false at all times since merging of parameters with another
     * operator is not possible.
     *
     * @param ezcTemplateOperatorTstNode $operator
     * @return bool
     */
    public function canMergeParametersOf( ezcTemplateOperatorTstNode $operator )
    {
        // We never allow merging.
        return false;
    }

    /**
     *
     * @retval ezcTemplateAstNode
     * @todo Not implemented yet.
     */
    public function transform()
    {
    }

}
?>
