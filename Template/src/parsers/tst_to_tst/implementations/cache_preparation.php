<?php
/**
 * File containing the ezcTemplateCachePreparation
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * 
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCachePreparation extends ezcTemplateTstWalker
{
    public $useVariableTst = array();

    public function __construct()
    {
    }

    /* Move the USE variable to the top of the program.
     */
    /*
    public function visitDeclarationTstNode( ezcTemplateDeclarationTstNode $node )
    {
        $symbolTable = ezcTemplateSymbolTable::getInstance();


        if ( $symbolTable->retrieve( $node->variable->name ) == ezcTemplateSymbolTable::IMPORT )
        {
            $this->useVariableTst[] = $this->nodePath[0]->elements[$this->statements[0] + $this->offset[0]];   // $this->nodePath[0]->elements[0];
            array_splice( $this->nodePath[0]->elements, $this->statements[0] + $this->offset[0], 1 ); 
            $this->offset[0] -= 1;
        }

        $this->acceptAndUpdate( $node->variable );

        if ( $node->expression !== null ) 
        {
            $this->acceptAndUpdate( $node->expression );
        }
    }
     */
}

?>
