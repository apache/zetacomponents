<?php
/**
 * File containing the ezcTemplateMultiplicationAssignmentOperatorAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents the PHP multiplication assignment operator *=
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateMultiplicationAssignmentOperatorAstNode extends ezcTemplateAssignmentOperatorAstNode
{
    /**
     * Returns a text string representing the PHP operator.
     * @return string
     */
    public function getOperatorPHPSymbol()
    {
        return '*=';
    }
}
?>
