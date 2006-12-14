<?php

class ezcTemplateTstToAstCachedTransformer extends ezcTemplateTstToAstTransformer
{
    protected $cacheInfo = null;
    protected $preparedCache = null;

    private $template = null;
    private $cacheName = null;

    private $cacheSystem = null;

    private $isInDynamicBlock = false;


    public function __construct( $parser, $cacheInfo, $preparedCache ) 
    {
        parent::__construct( $parser );

        $this->cacheInfo = $cacheInfo;
        $this->preparedCache = $preparedCache;
        
        // XXX 
        $this->template = $parser->template;
        $this->cacheSystem = $parser->template->configuration->cacheSystem;

    }


    public function __destruct()
    {
    }

    /**
     * Removes the old cache file
     */
    protected function removeOldCache( $cachePath )
    {
        if ( file_exists( $cachePath ) )
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


    public function visitProgramTstNode( ezcTemplateProgramTstNode $type )
    {
        if ( $this->programNode === null )
        {
            $this->programNode = new ezcTemplateRootAstNode();
            $this->outputVariable->push( "_ezcTemplate_output" );

            $this->programNode->appendStatement( $this->outputVariable->getInitializationAst() );


            // XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX

            $cacheKeys = array();
            foreach ( $this->cacheInfo->keys as $key )
            {
                // Translate the 'old' variableName to the new name.
                $k = $key->accept($this);
                $cacheKeys[] = $k->name;
            }

            $this->cacheSystem->setCacheKeys( $cacheKeys );


            if ( $this->cacheInfo->ttl !== null ) 
            {
                $ttl = $this->cacheInfo->ttl->accept($this);
                $this->cacheSystem->setTTL( $ttl );
            }

            $this->cacheSystem->setStream( $this->parser->template->stream );
            $this->cacheSystem->initializeCache();

            // $cacheFileName = "/tmp/cache/" . str_replace( '/', "-", $this->template->stream ); 

            // Get the code for the: 'cache exists'. Determining whether the cache data is available.
            $cacheExists = $this->cacheSystem->getCacheExists();
            $ifCondition = array_pop( $cacheExists ); 

            // Create the if statement that checks whether the cache file exists.
            $if = new ezcTemplateIfAstNode();
            $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();

            $cb->condition = $ifCondition;
            $cb->body = new ezcTemplateBodyAstNode();

            // $cb->body->statements = $type->statements;


                  // Inside.
        $cb->body->appendStatement( $this->_fopenCacheFileWriteMode() ); // $fp = fopen( $this->cache, "w" ); 

        $cb->body->appendStatement( $this->_fwritePhpOpen() );                 // fwrite( $fp, "<" . "?php\n" );
        $cb->body->appendStatement( $this->_assignEmptyString("total") );      // $total = ""
        $cb->body->appendStatement( $this->_fwriteLiteral("\\\$_ezcTemplate_output = '';\\n") );      // fwrite( $fp, "\\\$_ezcTemplate_output = '';\\n" );



            // XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX

            foreach ( $type->elements as $element )
            {
                $astNode = $element->accept( $this );
                if ( is_array( $astNode ) )
                {
                    foreach ( $astNode as $ast )
                    {
                        $cb->body->statements[] = $ast;
                    }
                }
                else
                {
                    $cb->body->statements[] = $astNode;

                    // $this->programNode->appendStatement( $astNode );

                }
            }
            
        // Create the 'else' part. The else should 'include' (and execute) the cached file. 
        $if->conditions[] = $else = new ezcTemplateConditionBodyAstNode();
        $else->body = new ezcTemplateBodyAstNode();

        $else->body->statements = array();
        $else->body->statements[] =  $this->_includeCache();


            // /////////////////////////////////////////////
            // 
            // 
            // RETURN STATEMENT inside..
            // fwrite( $fp, "\\\$_ezcTemplate_output .= " . var_export( $ezcTemplate_output, true) . ";" ); 
            $cb->body->appendStatement( $this->_fwriteVarExportVariable( "_ezcTemplate_output", true, true) );

            // $total .= $_ezcTemplate_output;
            $cb->body->appendStatement( $this->_concatAssignVariable( "_ezcTemplate_output", "total") );
                
            // fclose($fp);  
            $cb->body->appendStatement( $this->_fclose() );

            // $_ezcTemplate_output = $total;
            $cb->body->appendStatement( $this->_assignVariable( "total", "_ezcTemplate_output" ) );


            $cb->body->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );


            // Outside.
        
        // Add the 'use' statement, that is removed by the prepareCache walker.
        // XXX can probably be an array, test it.
        foreach ( $this->preparedCache->useVariableTst as $useVariable)
        {
            $use = $useVariable->accept($this);
            $this->programNode->appendStatement( $use );
        }

        
            $ttlStatements = $this->cacheSystem->checkTTL();
            foreach ( $ttlStatements as $s )
            {
                $this->programNode->appendStatement( $s );
            }

            $this->programNode->appendStatement( $if );


            
            // RETURN STATEMENT outside..
            $this->programNode->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );

        }
    }

    public function visitReturnTstNode( ezcTemplateReturnTstNode $node )
    {
        if ( $this->isInDynamicBlock )
        {
            // Do not add additional cache stuff, because that is written by the dynamic block.
            return parent::visitReturnTstNode( $node );
        }

        $astNodes = array();

        foreach ( $node->variables as $var => $expr )
        {
            $assign = new ezcTemplateAssignmentOperatorAstNode();
            $assign->appendParameter( new ezcTemplateVariableAstNode( "this->receive->" . $var ) );

            if ( $expr === null )
            {
               if ( $this->parser->symbolTable->retrieve( $var ) == ezcTemplateSymbolTable::IMPORT )
               {
                    $assign->appendParameter( new ezcTemplateVariableAstNode( "this->send->".$var ) );
               }
               else
               {
                    $assign->appendParameter( new ezcTemplateVariableAstNode( $var ) );
               }
            }
            else
            {
                $assign->appendParameter( $expr->accept( $this ) );
            }

            $astNodes[] = new ezcTemplateGenericStatementAstNode( $assign );


            // Add the cache .
            $astNodes[] = $this->_fwriteVarExportVariable( "this->receive->" . $var , false, false );
        }
        
        // Some extra stuff.
        $astNodes[] = $this->_fwriteVarExportVariable( "_ezcTemplate_output", true, true);

        // $total .= $_ezcTemplate_output;
        $astNodes[] = $this->_concatAssignVariable( "_ezcTemplate_output", "total");
            
        // fclose($fp);  
        $astNodes[] = $this->_fclose();

        // $_ezcTemplate_output = $total;
        $astNodes[] = $this->_assignVariable( "total", "_ezcTemplate_output" );



        $astNodes[] = new ezcTemplateReturnAstNode( /*$this->outputVar*/ $this->outputVariable->getAst() );
        return $astNodes;
    }
    
 
    public function visitDynamicBlockTstNode( ezcTemplateDynamicBlockTstNode $node )
    {
        // Write the variables introduced in the static part to the cache.
        $symbolTable = ezcTemplateSymbolTable::getInstance();
        $symbols = $symbolTable->retrieveSymbolsWithType( array( ezcTemplateSymbolTable::VARIABLE, ezcTemplateSymbolTable::CYCLE ) );

        $newStatement = array();
        foreach ( $symbols as $s )
        {
            if (array_key_exists( $s, $this->declaredVariables ) )
            {
                $newStatement[] = $this->_fwriteVarExportVariable( "_ezc_".$s, false, false );
            }
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
        $newStatement[] = new ezcTemplatePhpCodeAstNode( "\$code = '" );

       
        $this->isInDynamicBlock = true;
        $tmp = new ezcTemplateDynamicBlockAstNode( $this->createBody( $node->elements ) );
        $tmp->escapeSingleQuote = true;
        $newStatement[] = $tmp;
        $this->isInDynamicBlock = false;

        // $newStatement = array();
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

        return $newStatement;
    }

    public function visitCacheTstNode( ezcTemplateCacheTstNode $type )
    {
        if ( $type->type == ezcTemplateCacheTstNode::TYPE_CACHE_TEMPLATE )
        {
            // Modify the root node.
            $this->programNode->cacheTemplate = true;

            foreach ( $type->keys as $key )
            {
                // Translate the 'old' variableName to the new name.
                $k = $key->accept($this);
                $this->programNode->cacheKeys[] = $k->name;
            }

            // And translate the ttl.
            if ( $type->ttl != null ) 
            {
                $this->programNode->ttl = $type->ttl->accept($this);
            }

            return new ezcTemplateNopAstNode();
        }
        else
        {
            var_dump ($type );
            $cb = new ezcTemplateCacheBlockAstNode( $type->elements->accept($this) );
            
            return $cb;
        }
    }

}

?>
