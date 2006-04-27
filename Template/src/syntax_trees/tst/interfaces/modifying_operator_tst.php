<?php
/**
 * File containing the ezcTemplateModifyingOperatorTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Interface for modifying operator elements in parser trees.
 *
 * Modifying operators are those which directly alters their operand.
 * These operators are currently: ++$a, --$a, $a++ and $a--
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateModifyingOperatorTstNode extends ezcTemplateOperatorTstNode
{
    /**
     * Initialize element with source and cursor positions.
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end,
                                 $precedence, $order, $associativity )
    {
        parent::__construct( $source, $start, $end,
                             $precedence, $order, $associativity );
    }
}
?>
