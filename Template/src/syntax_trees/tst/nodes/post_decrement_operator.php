<?php
/**
 * File containing the ezcTemplatePostDecrementOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Fetching of property value in an inline expression.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplatePostDecrementOperatorTstNode extends ezcTemplateModifyingOperatorTstNode
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
                             10, 1, self::NON_ASSOCIATIVE );
        $this->maxParameterCount = 1;
    }

    public function symbol()
    {
        return '<type>--';
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
