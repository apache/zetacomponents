<?php
/**
 * File containing the ezcTemplateTstNodeVisitor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
