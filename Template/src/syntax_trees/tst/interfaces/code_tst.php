<?php
/**
 * File containing the ezcTemplateCodeTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Element interface representing code found in the template source code.
 *
 * Code is abstract and used by both text and block nodes, like the EBNF:
 * <code>
 * Code ::= ( Text | Block )*
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
abstract class ezcTemplateCodeTstNode extends ezcTemplateTstNode
{
    /**
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
    }




}
?>
