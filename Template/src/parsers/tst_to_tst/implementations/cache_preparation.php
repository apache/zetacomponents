<?php
/**
 * File containing the ezcTemplateCachePreparation
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The entire TST tree, doing nothing.
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
    public function visitDeclarationTstNode( ezcTemplateDeclarationTstNode $node )
    {
        $symbolTable = ezcTemplateSymbolTable::getInstance();
        if ( $symbolTable->retrieve( $node->variable->name ) == ezcTemplateSymbolTable::IMPORT )
        {
            // Move to the top of the program.
            
            // var_dump ($this->statements );
            // var_dump ($this->nodePath[0] );

           
            // Remove the "USE".
            // XXX Fix offset, fix test. (multiple use deletion)

            $tmp = $this->nodePath[0]->elements[ $this->statements[0] ];
            array_splice( $this->nodePath[0]->elements, $this->statements[0], 1);

            // Insert the "USE".
            // array_splice( $this->nodePath[0]->elements, 0, 0, array($tmp));
            // 

            $this->useVariableTst[] = $tmp;


            /*
            $offset = $this->statements[0] + $this->offset[0];

            // Remove the declaration of the USE variables.
            array_splice( $this->nodePath[0]->statements, $offset, 1 ); 
            $this->offset[0] -= 1; 

            // XXX: 2nd, because the 'if' produces also a nodePath.
            array_unshift( $this->nodePath[2]->statements, $node );
            // $this->offset[2] += 1; 
            */
        }

        $this->acceptAndUpdate( $node->variable );

        if ( $node->expression !== null ) 
        {
            $this->acceptAndUpdate( $node->expression );
        }
    }

}

?>
