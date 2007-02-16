<?php
/**
 * File containing the ezcTemplateTstToAstCachedTransformer class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Use this transformer when caching is enabled.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateTstToAstCachedTransformer extends ezcTemplateTstToAstTransformer
{
    protected $cacheInfo = null;
    protected $preparedCache = null;

    private $template = null;
    private $cacheName = null;

    private $cacheSystem = null;

    private $isInDynamicBlock = false;

    private $cacheBaseName = null;


    public function __construct( $parser, $cacheInfo, $preparedCache ) 
    {
        parent::__construct( $parser );

        $this->cacheInfo = $cacheInfo;
        $this->preparedCache = $preparedCache;
        
        // XXX 
        $this->template = $parser->template;
        //$this->cacheSystem = $parser->template->configuration->cacheSystem;

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
     *  Returns the ast tree:  include( $_ezcTemplateCache ); 
     */
    protected function _includeCache()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "include", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) ); 
    }

    /**
     *  Returns the ast tree:  $fp = fopen( $_ezcTemplateCache, "w");
     */
    protected function _fopenCacheFileWriteMode()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->createVariableNode( "fp" ), new ezcTemplateFunctionCallAstNode( "fopen", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ), new ezcTemplateLiteralAstNode( "w")  )) ) );

    }

    /**
     *  Returns the ast tree:  fwrite( $fp, "<" . "?php\n" );
     */
    protected function _fwritePhpOpen()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->createVariableNode( "fp" ),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode('<'), new ezcTemplateLiteralAstNode("?php\n" ) ) ) ) );
    }

    /**
     *  Returns the ast tree: <variable> = "";
     */
    protected function _assignEmptyString( $variable )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->createVariableNode( $variable ), new ezcTemplateLiteralAstNode( "") ) );
    }

    /**
     *  Returns the ast tree: <variableDst> .= <variableSrc>;
     */
    protected function _concatAssignVariable( $variableSrc, $variableDst )
    {
         return new ezcTemplateGenericStatementAstNode( new ezcTemplateConcatAssignmentOperatorAstNode( $this->createVariableNode( $variableDst ), $this->createVariableNode( $variableSrc ) ) );
    }

    /**
     *  Returns the ast tree: <variableDst> = <variableSrc>;
     */
    protected function _assignVariable( $variableSrc, $variableDst )
    {
         return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->createVariableNode( $variableDst ), $this->createVariableNode( $variableSrc ) ) );
    }


    /**
     *  Returns the ast tree: fwriteLiteral( $fp, <literal_value> ); 
     */
    protected function _fwriteLiteral( $literalValue )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->createVariableNode( "fp" ), new ezcTemplateLiteralAstNode( $literalValue ) ) ) );  

    }

    /**
     *  Returns the ast tree: fwriteVariable( $fp, $<variableName> ); 
     */
    protected function _fwriteVariable( $variableName )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->createVariableNode( "fp" ), $this->createVariableNode( $variableName ) ) ) );  
    }


    /**
     *  Returns the ast tree: return $<variableName>;
     */
    protected function _returnVariable( $variableName )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateReturnAstNode ( $this->createVariableNode( $variableName ) ) );
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array($this->createVariableNode("fp"),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode("\$".$variableName." ". ($concat ? ".=" : "=") ." "), new ezcTemplateConcatOperatorAstNode( new ezcTemplateFunctionCallAstNode(  "var_export", array( $this->createVariableNode("$variableName"), new ezcTemplateLiteralAstNode(true) ) ), new ezcTemplateLiteralAstNode(";\n" . ($fwritePhpClose ? " ?>" : "" )) ) ) ) ) );
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fclose", array( $this->createVariableNode( "fp" ) ) ) ) ;
    }

    protected function getCacheBaseName()
    {
        if ( $this->cacheBaseName === null )
        {
            $rpTemplate = realpath( $this->template->configuration->templatePath );
            $rpStream = realpath( $this->parser->template->stream );

            if ( strncmp( $rpTemplate, $rpStream, strlen( $rpTemplate ) ) == 0 )
            { 
                $fileName = substr( $rpStream, strlen( $rpTemplate ) );
            }
            else
            {
                $fileName = $rpStream;
            }

            $this->cacheBaseName = $this->template->configuration->compilePath . DIRECTORY_SEPARATOR . $this->template->configuration->cachedTemplatesPath . DIRECTORY_SEPARATOR . str_replace( '/', "-", $fileName ); 
        }

        return $this->cacheBaseName;
    }


    protected function deleteOldCache()
    {
        $bn = $this->getCacheBaseName();

        $base = basename( $bn );
        $dir = dirname( $bn); 

        if ( is_dir( $dir ) )
        {
            $dp = opendir( $dir );
            while ( false !== ( $file = readdir( $dp ) ) )
            {
                if ( strncmp( $base, $file, strlen($base ) ) == 0 ) 
                {
                    unlink( $dir . DIRECTORY_SEPARATOR . $file );
                }
            }

            closedir( $dp );
        }
    }

    /**
     *  Returns the ast tree:  !file_exists( [ $_ezcTemplateCache ] )
     */
    protected function notFileExistsCache()
    {
        if( $this->template->configuration->cacheManager !== false )
        {
            // !$this->template->configuration->cacheManager->isValid( $cacheName ) || !file_exist()
            $a = new ezcTemplateLogicalNegationOperatorAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->isValid", array( new ezcTemplateVariableAstNode( "this->template"), new ezcTemplateLiteralAstNode( $this->parser->template->stream ), new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) );
            $b = new ezcTemplateLogicalNegationOperatorAstNode( new ezcTemplateFunctionCallAstNode( "file_exists", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) );
            
           return new ezcTemplateLogicalOrOperatorAstNode( $a, $b );
        }
        else
        {

            return new ezcTemplateLogicalNegationOperatorAstNode( new ezcTemplateFunctionCallAstNode( "file_exists", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) );
        }
    }


    public function visitProgramTstNode( ezcTemplateProgramTstNode $type )
    {
        if ( $this->programNode === null )
        {
            $this->programNode = new ezcTemplateRootAstNode();
            $this->handleProgramHeader( $this->programNode );
            $this->outputVariable->push( self::INTERNAL_PREFIX . "output" );

            $this->programNode->appendStatement( $this->outputVariable->getInitializationAst() );


            // XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX

            $cacheKeys = array();
            foreach ( $this->cacheInfo->keys as $key => $value )
            {
                // Translate the 'old' variableName to the new name.
                $k = $value->accept($this);
                $cacheKeys[str_replace( "this->send->", "use:" , $k->name )] = $k->name;
            }

            $ttl = null;
            if ( $this->cacheInfo->ttl !== null ) 
            {
                $ttl = $this->cacheInfo->ttl->accept($this);
                //$this->cacheSystem->setTTL( $ttl );
            }

            $dir = $this->template->configuration->compilePath . DIRECTORY_SEPARATOR . $this->template->configuration->cachedTemplatesPath;

            if ( !file_exists( $dir ) )
            {
                mkdir( $dir );
            }
            
            $this->deleteOldCache();


            $ifCondition = $this->notFileExistsCache();


            // Create the if statement that checks whether the cache file exists.
            $if = new ezcTemplateIfAstNode();
            $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();

            $cb->condition = $ifCondition;
            $cb->body = new ezcTemplateBodyAstNode();

            // $cb->body->statements = $type->statements;


            // Inside.
            
            /// startCaching(); 
            $cplen = strlen( $this->parser->template->configuration->compilePath );
            if ($this->template->configuration->cacheManager !== false )
            {
                $cb->body->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->startCaching", array( new ezcTemplateVariableAstNode("this->template"), new ezcTemplateLiteralAstNode( $this->parser->template->stream ), new ezcTemplateVariableAstNode("_ezcTemplateCache" ), new ezcTemplateVariableAstNode("_ezcCacheKeys") ) ) ) );
            }
          
            $cb->body->appendStatement( $this->_fopenCacheFileWriteMode() ); // $fp = fopen( $this->cache, "w" ); 

            $cb->body->appendStatement( $this->_fwritePhpOpen() );                 // fwrite( $fp, "<" . "?php\n" );
            $cb->body->appendStatement( $this->_assignEmptyString("total") );      // $total = ""
            $cb->body->appendStatement( $this->_fwriteLiteral( "\$" . self::INTERNAL_PREFIX . "output = '';\n") );      // fwrite( $fp, "\\\$_ezcTemplate_output = '';\\n" );



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

        // Close the caching.
            if ($this->template->configuration->cacheManager !== false )
            {
                $cb->body->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->stopCaching", array() )));
            }
 
        
            $cb->body->appendStatement( $this->_fwriteVarExportVariable( self::INTERNAL_PREFIX . "output", true, true) );

            // $total .= $_ezcTemplate_output;
            $cb->body->appendStatement( $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total") );
                
            // fclose($fp);  
            $cb->body->appendStatement( $this->_fclose() );

            // $_ezcTemplate_output = $total;
            $cb->body->appendStatement( $this->_assignVariable( "total", self::INTERNAL_PREFIX . "output" ) );


            $cb->body->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );


            // Outside.
        
            // Add the 'use' statement, that is removed by the prepareCache walker.
            // XXX can probably be an array, test it.
            foreach ( $this->preparedCache->useVariableTst as $useVariable)
            {
                $use = $useVariable->accept($this);
                if( is_array( $use ) )
                {
                    foreach ( $use as $u )
                    {
                        $this->programNode->appendStatement( $u );
                    }
                }
                else
                {
                    $this->programNode->appendStatement( $use );
                }
            }

            $this->addCacheKeys( $this->programNode, $cacheKeys );
            
            $ttlStatements = $this->checkTTL( $ttl, $cacheKeys );
            foreach ( $ttlStatements as $s )
            {
                $this->programNode->appendStatement( $s );
            }

            $this->programNode->appendStatement( $if );


            
            // RETURN STATEMENT outside..
            $this->programNode->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );

        }
    }

    protected function addCacheKeys( $programNode, $cacheKeys )
    {
        $hasCacheKey = false;
        $programNode->appendStatement( new ezcTemplatePhpCodeAstNode( '$_ezcCacheKeys = array();' ."\n" ) );

        foreach ( $cacheKeys as $key => $value )
        {
            $programNode->appendStatement( new ezcTemplatePhpCodeAstNode( '$_ezcCacheKeys[\''.$key.'\'] = '. 'is_object( $'.$value.' ) && method_exists( $'.$value.', "cacheKey" ) ? $'.$value.'->cacheKey() : $'.  $value . ";\n" ) );

//            $programNode->appendStatement( new ezcTemplatePhpCodeAstNode( '$_ezcCacheKeys[\''.$value.'\'] = '. 'md5( var_export( is_object( $'.$value.' ) && method_exists( $'.$value.', "cacheKey" ) ? $'.$value.'->cacheKey() : $'.  $value . ', true ) )' . ";\n" ) );

             
            $hasCacheKey = true;
        }

        if( $hasCacheKey )
        {
            $code = '$_ezcTemplateCache = \'' . $this->getCacheBaseName() . "'" ;
            foreach ( $cacheKeys as $key => $value )
            {
                $code .= " . '-'". '. md5( var_export( $_ezcCacheKeys[\''.$key.'\'], true ))';
            }

            $programNode->appendStatement(new ezcTemplatePhpCodeAstNode( $code . ";\n" ) );
        }
        else
        {
            $programNode->appendStatement(new ezcTemplatePhpCodeAstNode( '$_ezcTemplateCache = \'' . $this->getCacheBaseName() . "';\n" ) );
        }
    }

    protected function checkTTL( $ttl, $cacheKeys )
    {
        $statements = array();

        if ( $ttl !== null )
        {
            // Create the if statement that checks whether the cache file exists.
            $if = new ezcTemplateIfAstNode();
            $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();


            $time = new ezcTemplateFunctionCallAstNode( "time", array() );
            $time->checkAndSetTypeHint();
            
            // if ( file_exists( \$_ezcTemplateCache ) && filemtime( \$_ezcTemplateCache ) + ( /*[ TTL ]*/ ) < time() )
            // {
            //     echo 'REMOVE THE FILE';
            //     // unlink( [FILE] )
            // }\n" );

            $cb->condition = new ezcTemplateLogicalAndOperatorAstNode( new ezcTemplateFunctionCallAstNode( "file_exists", array(new ezcTemplateVariableAstNode( "_ezcTemplateCache" )  ) ), new ezcTemplateLessThanOperatorAstNode( new ezcTemplateAdditionOperatorAstNode( new ezcTemplateFunctionCallAstNode( "filemtime", array(new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) )),  new ezcTemplateParenthesisAstNode( $ttl )  ) , $time ) );

            $cb->body = new ezcTemplateBodyAstNode();

            $cb->body->statements = array();
            
            $cb->body->statements[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "unlink", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) );

            $statements[] = $if;
        }

        return $statements;
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
            $assign->appendParameter( $this->createVariableNode( "this->receive->" . $var ) );

            if ( $expr === null )
            {
               if ( $this->parser->symbolTable->retrieve( $var ) == ezcTemplateSymbolTable::IMPORT )
               {
                    $assign->appendParameter( $this->createVariableNode( "this->send->" . $var ) );
               }
               else
               {
                    $assign->appendParameter( $this->createVariableNode( $var ) );
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
        $astNodes[] = $this->_fwriteVarExportVariable( self::INTERNAL_PREFIX . "output", true, true);

        // $total .= $_ezcTemplate_output;
        $astNodes[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total");
            
        // fclose($fp);  
        $astNodes[] = $this->_fclose();

        // $_ezcTemplate_output = $total;
        $astNodes[] = $this->_assignVariable( "total", self::INTERNAL_PREFIX . "output" );



        $astNodes[] = new ezcTemplateReturnAstNode( $this->outputVariable->getAst() );
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
                $newStatement[] = $this->_fwriteVarExportVariable( "t_".$s, false, false );
            }
        }
        
        $newStatement[] = $this->_comment(" ---> start {dynamic}");
        
        // $total .= $_ezcTemplate_output
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total");

        // fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
        $newStatement[] = $this->_fwriteVarExportVariable( self::INTERNAL_PREFIX . "output", true, false);

        // $_ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString( self::INTERNAL_PREFIX . "output" );

        // $output .= $_ezcTemplate_output;
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total");

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
            new ezcTemplateFunctionCallAstNode( "eval", array( $this->createVariableNode( "code" ) ) ) );

        // $total .= _ezcTemplate_output
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total" ); 

        // $ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString( self::INTERNAL_PREFIX . "output" ); 

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


                if( $this->parser->symbolTable->retrieve($key->name) !== ezcTemplateSymbolTable::IMPORT)
                {
                    
                    throw new ezcTemplateParserException( $type->source, $type->endCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_USE_VARIABLE );
                }

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
            $cb = new ezcTemplateCacheBlockAstNode( $type->elements->accept($this) );
            
            return $cb;
        }
    }
}

?>
