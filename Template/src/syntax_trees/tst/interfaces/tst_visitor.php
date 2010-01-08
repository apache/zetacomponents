<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Visitor interface for the TST nodes.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
interface ezcTemplateTstNodeVisitor
{
    public function visitProgramTstNode( ezcTemplateProgramTstNode $type );
}
?>
