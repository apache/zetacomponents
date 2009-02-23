<?php
/**
 * File containing the ezcTemplateArrayAppendOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The ezcTemplateArrayAppendOperatorTstNode
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArrayAppendOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * Constructs a new ezcTemplateArrayAppendOperatorTstNode
     *
     * @param ezcTemplateSourceCode $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end,
                             9, 2, self::NON_ASSOCIATIVE,
                             '-' );
        $this->maxParameterCount = 1;
    }
}
?>
