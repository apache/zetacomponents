<?php
/**
 * File containing the ezcTemplatePlusOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Fetching of property value in an expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplatePlusOperatorTstNode extends ezcTemplateOperatorTstNode
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
                             7, 3, self::LEFT_ASSOCIATIVE,
                             '+' );
    }

}
?>
