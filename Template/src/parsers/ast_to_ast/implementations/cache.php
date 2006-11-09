<?php
/**
 * File containing the ezcTemplateAstToAstCache
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * An instance of this class 'walks' over the AST tree and inserts the cache implementation. 
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateAstToAstCache extends ezcTemplateAstWalker
{
    private $template = null;
    private $cacheName = null;

    private $cacheSystem = null;

    public function __construct( $template )
    {
        $this->template = $template;
        $this->cacheSystem = $this->template->configuration->cacheSystem;
    }

    public function __destruct()
    {
    }

    /**
     * Removes the old cache file
     */
    protected function removeOldCache( $cachePath )
    {
        if( file_exists( $cachePath ) )
        {
            unlink( $cachePath );
        }
    }

    /**
     *  Returns the ast tree:  include( [cacheSystem->getCacheFileName()] ); 
     */
    protected function _includeCache()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "include", array( $this->cacheSystem->getCacheFileName() ) ) ); 
    }

    /**
     *  Returns the ast tree:  $fp = fopen( [cacheSystem->getCacheFileName()], "w");
     */
    protected function _fopenCacheFileWriteMode()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( new ezcTemplateVariableAstNode("fp"), new ezcTemplateFunctionCallAstNode( "fopen", array( $this->cacheSystem->getCacheFileName(), new ezcTemplateLiteralAstNode( "w")  )) ) );

    }

    /**
     *  Returns the ast tree:  fwrite( $fp, "<" . "?php\n" );
     */
    protected function _fwritePhpOpen()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( new ezcTemplateVariableAstNode("fp"),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode('<'), new ezcTemplateLiteralAstNode('?php\\n' ) ) ) ) );
    }

    /**
     *  Returns the ast tree: <variable> = "";
     */
    protected function _assignEmptyString( $variable )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( new ezcTemplateVariableAstNode($variable), new ezcTemplateLiteralAstNode( "") ) );
    }

    /**
     *  Returns the ast tree: <variableDst> .= <variableSrc>;
     */
    protected function _concatAssignVariable( $variableSrc, $variableDst )
    {
         return new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( new ezcTemplateVariableAstNode($variableDst), new ezcTemplateVariableAstNode($variableSrc) ) );
    }

    /**
     *  Returns the ast tree: <variableDst> = <variableSrc>;
     */
    protected function _assignVariable( $variableSrc, $variableDst )
    {
         return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( new ezcTemplateVariableAstNode($variableDst), new ezcTemplateVariableAstNode($variableSrc) ) );
    }


    /**
     *  Returns the ast tree: fwriteLiteral( $fp, <literal_value> ); 
     */
    protected function _fwriteLiteral( $literalValue )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( new ezcTemplateVariableAstNode("fp"), new ezcTemplateLiteralAstNode( $literalValue ) ) ) );  

    }

    /**
     *  Returns the ast tree: fwriteVariable( $fp, $<variableName> ); 
     */
    protected function _fwriteVariable( $variableName )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( new ezcTemplateVariableAstNode("fp"), new ezcTemplateVariableAstNode( $variableName ) ) ) );  
    }


    /**
     *  Returns the ast tree: return $<variableName>;
     */
    protected function _returnVariable( $variableName )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateReturnAstNode ( new ezcTemplateVariableAstNode( $variableName ) ) );
    }

    /**
     *  Returns one of the following ast trees, depending on the variables $concat and $fwritePhpClose:  
     *
     *  fwrite( $fp, "\\\<variableName> = " . var_export( <variableName>, true) . "; ?>" );
     *  fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
     *  fwrite( $fp, "\\\<variableName> = " . var_export( <variableName>, true) . "; ?>" );
     *  fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
     */
    protected function _fwriteVarExportVariable( $variableName, $concat, $fwritePhpClose = false )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array(new ezcTemplateVariableAstNode("fp"),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode("\\\$".$variableName." ". ($concat ? ".=" : "=") ." "), new ezcTemplateConcatOperatorAstNode( new ezcTemplateFunctionCallAstNode(  "var_export", array( new ezcTemplateVariableAstNode("$variableName"), new ezcTemplateLiteralAstNode(true) ) ), new ezcTemplateLiteralAstNode(";\\n" . ($fwritePhpClose ? " ?>" : "" )) ) ) ) ) );
    }

    /**
     * Returns the ast tree that inserts comments.
     */
    protected function _comment( $str )
    {
        return new ezcTemplatePhpCodeAstNode( "// ". str_replace( "\n", "\n// ", $str ) . "\n" );
    }

    /**
     *  Returns the ast tree: fclose( $fp);
     */
    protected function _fclose()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fclose", array( new ezcTemplateVariableAstNode( "fp" ) ) ) ) ;
    }


    /**
     * This should be the first node found in the AST-tree.
     *
     * Do not replace the &$type because the changes are not visible in the Template.
     */
    public function visitRootAstNode( ezcTemplateRootAstNode &$type )
    {
        // Should the template be cached?
        if( !$type->cacheTemplate )
        {
            // No, ET phone home
            return;
        }

        $this->cacheSystem->setCacheKeys( $type->cacheKeys );
        $this->cacheSystem->setTTL( $type->ttl );
        $this->cacheSystem->setStream( $this->template->stream );
        $this->cacheSystem->initializeCache();


        //$cacheFileName = "/tmp/cache/" . str_replace( '/', "-", $this->template->stream ); 

        // Get the code for the: 'cache exists'. Determining whether the cache data is available.
        $cacheExists = $this->cacheSystem->getCacheExists();
        $ifCondition = array_pop( $cacheExists ); 

        // Create the if statement that checks whether the cache file exists.
        $if = new ezcTemplateIfAstNode();
        $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();

        $cb->condition = $ifCondition;
        $cb->body = new ezcTemplateBodyAstNode();

        // Move the current statements under the 'if'. (Or: Create an if around the current statements) 
        $cb->body->statements = $type->statements;

        // Create the 'else' part. The else should 'include' (and execute) the cached file. 
        $if->conditions[] = $else = new ezcTemplateConditionBodyAstNode();
        $else->body = new ezcTemplateBodyAstNode();
        $else->body->statements = array();

        $else->body->statements[] =  $this->_includeCache();

        $type->statements = array();

        $type->statements = array_merge( $type->statements, $this->cacheSystem->checkTTL() );
        

        $type->statements[] = new ezcTemplatePhpCodeAstNode("clearstatcache();\n");


        // The current statements are already moved to the if node, Don't need them here.
        $type->statements = array_merge( $type->statements, $cacheExists );

        // Of course we need the if-statement we just created.
        $type->statements[] = $if;

        // Create the statements that belong (on top) inside the if-body.
        $statements = array();

        $statements[] = $this->_fopenCacheFileWriteMode();                              // $fp = fopen( $this->cache, "w" ); 

        $statements[] = $this->_fwritePhpOpen();                                        // fwrite( $fp, "<" . "?php\n" );
        $statements[] = $this->_assignEmptyString("total");                             // $total = ""
        $statements[] = $this->_fwriteLiteral("\\\$_ezcTemplate_output = '';\\n");      // fwrite( $fp, "\\\$_ezcTemplate_output = '';\\n" );

        // Insert the statements in the front of the statement array: $cb->body->statements
        array_splice($cb->body->statements, 0, 0, $statements);

        // No need to increase the $this->offset counter, because the parent loops over it (included the new statements).
        parent::visitRootAstNode( $type );

        // Append an additional return $_ezcTemplate_output;  (The previous is gone in the if statements.) 
        $type->statements[] = $this->_returnVariable("_ezcTemplate_output");
    }

    public function visitReturnAstNode( ezcTemplateReturnAstNode $return )
    {
        // These statements should be added above the return-statement.
        $statements = array();
        
        //fwrite( $fp, "\\\$_ezcTemplate_output .= " . var_export( $ezcTemplate_output, true) . ";" ); 
        $statements[] = $this->_fwriteVarExportVariable( "_ezcTemplate_output", "true", true);

        // $total .= $_ezcTemplate_output;
        $statements[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");
            
        // fclose($fp);  
        $statements[] = $this->_fclose();

        // $_ezcTemplate_output = $total;
        $statements[] = $this->_assignVariable( "total", "_ezcTemplate_output" );

        // Insert the statements at the current line.
        array_splice( $this->nodePath[0]->statements, $this->statements[0] + $this->offset[0], 0, $statements );

        $this->offset[0] += sizeof( $statements );
    }

    public function visitIfAstNode( ezcTemplateIfAstNode $node )
    {
        $symbolTable = ezcTemplateSymbolTable::getInstance();

        if( $node->tstNode instanceof ezcTemplateDeclarationTstNode )
        {
            
            if ( $symbolTable->retrieve( $node->tstNode->variable->name ) == ezcTemplateSymbolTable::IMPORT )
            {
                $offset = $this->statements[0] + $this->offset[0];

                // Remove the declaration of the USE variables.
                array_splice( $this->nodePath[0]->statements, $offset, 1 ); 
                $this->offset[0] -= 1; 

                // XXX: 2nd, because the 'if' produces also a nodePath.
                array_unshift( $this->nodePath[2]->statements, $node );
                //$this->offset[2] += 1; 
            }
        }

        parent::visitIfAstNode($node);
    }
    
    public function visitDynamicBlockAstNode( ezcTemplateDynamicBlockAstNode $node )
    {
        // Write the variables introduced in the static part to the cache.
        $symbolTable = ezcTemplateSymbolTable::getInstance();
        $symbols = $symbolTable->retrieveSymbolsWithType( array( ezcTemplateSymbolTable::VARIABLE, ezcTemplateSymbolTable::CYCLE ) );

        $newStatement = array();

        // Initialize the values.
        // XXX: Check also for the used variables.
        foreach( $symbols as $symbol )
        {
            $newStatement[] = $this->_fwriteVarExportVariable( $symbol, false, false );
        }
        
        $newStatement[] = $this->_comment(" ---> start {dynamic}");
        
        // $total .= $_ezcTemplate_output
        $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");

        // fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
        $newStatement[] = $this->_fwriteVarExportVariable( "_ezcTemplate_output", true, false);

        // $_ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString("_ezcTemplate_output");

        // $output .= $_ezcTemplate_output;
        $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");

        // Place everything in the code block.
        // XXX scan for quote: '
        $newStatement[] = new ezcTemplatePhpCodeAstNode( "\$code = '" );

        // Insert the new statements.
        array_splice($this->nodePath[0]->statements, $this->statements[0] + $this->offset[0], 0, $newStatement);
        $this->offset[0] += sizeof( $newStatement );


        // Process the information within the dynamic block. 
        $this->acceptAndUpdate( $node->body );

        // Set the $node to escape quote.
        $node->escapeSingleQuote = true;


        $newStatement = array();
        $newStatement[] = new ezcTemplatePhpCodeAstNode( "';\n" );

        // fwrite( $fp, $code );
        $newStatement[] = $this->_fwriteVariable( "code" ); 

        // eval( $code );
        $newStatement[] = new ezcTemplateGenericStatementAstNode( 
            new ezcTemplateFunctionCallAstNode( "eval", array( new ezcTemplateVariableAstNode("code") ) ) );

        // $total .= _ezcTemplate_output
        $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total" ); 

        // $ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString("_ezcTemplate_output"); 

        $newStatement[] = $this->_comment(" <--- stop {/dynamic}");

        array_splice($this->nodePath[0]->statements, $this->statements[0] + $this->offset[0] + 1, 0, $newStatement);
        $this->offset[0] += sizeof($newStatement);
    }
 
/*   
    public function visitNopAstNode( ezcTemplateNopAstNode $node )
    {
        // The nop-nodes may contain extra information regarding the {dynamic} blocks.
        if( $node->type == ezcTemplateNopAstNode::TYPE_DYNAMIC_OPEN )
        {
            // Write the variables introduced in the static part to the cache.
            $symbolTable = ezcTemplateSymbolTable::getInstance();
            $symbols = $symbolTable->retrieveSymbolsWithType( array( ezcTemplateSymbolTable::VARIABLE, ezcTemplateSymbolTable::CYCLE ) );

            $newStatement = array();

            // Initialize the values.
            // XXX: Check also for the used variables.
            foreach( $symbols as $symbol )
            {
                $newStatement[] = $this->_fwriteVarExportVariable( $symbol, false, false );
            }
            
            $newStatement[] = $this->_comment(" ---> start {dynamic}");
            
            // $total .= $_ezcTemplate_output
            $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");

            // fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
            $newStatement[] = $this->_fwriteVarExportVariable( "_ezcTemplate_output", true, false);

            // $_ezcTemplate_output = "";
            $newStatement[] = $this->_assignEmptyString("_ezcTemplate_output");

            // $output .= $_ezcTemplate_output;
            $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");

            // Place everything in the code block.
            // XXX scan for quote: '
            $newStatement[] = new ezcTemplatePhpCodeAstNode( "\$code = '" );

            // Insert the new statements.
            array_splice($this->nodePath[0]->statements, $this->statements[0] + $this->offset[0], 0, $newStatement);
            $this->offset[0] += sizeof( $newStatement );
        }
        elseif( $node->type == ezcTemplateNopAstNode::TYPE_DYNAMIC_CLOSE )
        {
            
            $newStatement = array();
            $newStatement[] = new ezcTemplatePhpCodeAstNode( "';\n" );

            // fwrite( $fp, $code );
            $newStatement[] = $this->_fwriteVariable( "code" ); 

            // eval( $code );
            $newStatement[] = new ezcTemplateGenericStatementAstNode( 
                new ezcTemplateFunctionCallAstNode( "eval", array( new ezcTemplateVariableAstNode("code") ) ) );

            // $total .= _ezcTemplate_output
            $newStatement[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total" ); 

            // $ezcTemplate_output = "";
            $newStatement[] = $this->_assignEmptyString("_ezcTemplate_output"); 

            $newStatement[] = $this->_comment(" <--- stop {/dynamic}");

            array_splice($this->nodePath[0]->statements, $this->statements[0] + $this->offset[0], 0, $newStatement);
            $this->offset[0] += sizeof($newStatement);
        }
    }
 */
}
?>
