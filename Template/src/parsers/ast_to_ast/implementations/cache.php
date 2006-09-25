<?php
/**
 * File containing the ezcTemplateAstToAstContextAppender
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAstToAstCache extends ezcTemplateAstWalker
{
    private $template = null;
    private $uniqueID = null;

    public function __construct( $template )
    {
        $this->template = $template;
    }

    public function __destruct()
    {
    }

    public function visitRootAstNode( ezcTemplateRootAstNode &$type )
    {
        if( !$type->cacheTemplate )
        {
            return;
        }

        $this->uniqueID = uniqid();
        

        
        // Need to make a tree duplication?
        // To prevent tree madness..

         //////////////////////
        // Write: $c = 
         //   $c = new ezcCacheStorageFilePlain("/tmp/cache/");

         //   if ( ( $data = $c->restore( "pizza" ) ) === false )
         //   {
         //       $dataOfFirstItem = "Plain cache stored on " . date( 'Y-m-d, H:i:s' );
         //       $c->store( "pizzaboer", $dataOfFirstItem );
         //   }

        // Create $cache = new ...
        $createCacheLine = new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( new ezcTemplateVariableAstNode( "cache" ), new ezcTemplateNewAstNode ("ezcCacheStorageFilePlain", array( new ezcTemplateLiteralAstNode("/tmp/cache/") ) ) ) );

        $createDataLine = new ezcTemplateParenthesisAstNode( new ezcTemplateAssignmentOperatorAstNode( new ezcTemplateVariableAstNode( "data" ), new ezcTemplateObjectAccessOperatorAstNode( new ezcTemplateVariableAstNode( "cache"), new ezcTemplateFunctionCallAstNode( "restore", array(new ezcTemplateLiteralAstNode($this->uniqueID) ) ) ) ) ) ;


        $compare = new ezcTemplateIdenticalOperatorAstNode( $createDataLine, new ezcTemplateLiteralAstNode( false) );

        $cb = new ezcTemplateConditionBodyAstNode();
        $cb->condition = $compare;

        $cb->body = new ezcTemplateBodyAstNode();
        $cb->body->statements = $type->statements;

        $if = new ezcTemplateIfAstNode();
        $if->conditions[] = $cb;

        $type->statements = array();
        $type->statements[] = $createCacheLine;
        $type->statements[] = $if;


        parent::visitRootAstNode( $type );

        // return $data;
        $type->statements[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateReturnAstNode ( new ezcTemplateVariableAstNode( "data") ) );


        return;
     }

    public function visitReturnAstNode( ezcTemplateReturnAstNode $return )
    {
        // Write the to cache.
        // $cache->store( "template_identifier", $data );
        
        $a = new ezcTemplateGenericStatementAstNode( new ezcTemplateObjectAccessOperatorAstNode( new ezcTemplateVariableAstNode( "cache"), new ezcTemplateFunctionCallAstNode( "store", array(new ezcTemplateLiteralAstNode($this->uniqueID), new ezcTemplateVariableAstNode("_ezcTemplate_output") ) ) ) );

        array_splice($this->nodePath[0]->statements, $this->statements[0], 0, array($a) );


        /*

        echo ("Number: " . $this->statements[0] . "\n" );

        var_dump ($this->nodePath[0]->statements[$this->statements[0]]);

        exit();
        foreach( $this->nodePath as $n )
        {
            echo get_class( $n ) . "\n";
        }
        exit();

        var_dump( $return );
      */
        return;
        
    }




/*
    public function visitOutputAstNode( ezcTemplateOutputAstNode $type )
    {
        parent::visitOutputAstNode( $type );

        if ( $type->isRaw )
        {
            return $type;
        }
        return $this->context->transformOutput( $type->expression );
    }
 */


}
?>
