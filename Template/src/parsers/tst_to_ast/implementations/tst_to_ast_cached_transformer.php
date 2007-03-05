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
    /**
     * Contains the {cache_template} information. 
     */
    protected $cacheTemplate = null;

    protected $preparedCache = null;

    private $template = null;
    private $cacheName = null;

    private $cacheSystem = null;

    private $isInDynamicBlock = false;

    /**
     * True when in {cache_template} or inside a {cache_block}.
     */
    private $isInCacheBlock = false;
    private $cacheLevel = 0;

    private $cacheBaseName = null;


    protected $cacheBlockCounter = 0;

    public function __construct( $parser, $cacheTemplate, $preparedCache ) 
    {
        parent::__construct( $parser );

        $this->cacheTemplate = $cacheTemplate;
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

    protected function getFp()
    {
        return $this->createVariableNode( "fp" . $this->cacheLevel );
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateAssignmentOperatorAstNode( $this->getFp(), new ezcTemplateFunctionCallAstNode( "fopen", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ), new ezcTemplateLiteralAstNode( "w")  )) ) );

    }

    /**
     *  Returns the ast tree:  fwrite( $fp, "<" . "?php\n" );
     */
    protected function _fwritePhpOpen()
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->getFp(),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode('<'), new ezcTemplateLiteralAstNode("?php\n" ) ) ) ) );
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->getFp(), new ezcTemplateLiteralAstNode( $literalValue ) ) ) );  

    }

    /**
     *  Returns the ast tree: fwriteVariable( $fp, $<variableName> ); 
     */
    protected function _fwriteVariable( $variableName )
    {
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array( $this->getFp(), $this->createVariableNode( $variableName ) ) ) );  
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fwrite", array($this->getFp(),  new ezcTemplateConcatOperatorAstNode( new ezcTemplateLiteralAstNode("\$".$variableName." ". ($concat ? ".=" : "=") ." "), new ezcTemplateConcatOperatorAstNode( new ezcTemplateFunctionCallAstNode(  "var_export", array( $this->createVariableNode("$variableName"), new ezcTemplateLiteralAstNode(true) ) ), new ezcTemplateLiteralAstNode(";\n" . ($fwritePhpClose ? " ?>" : "" )) ) ) ) ) );
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
        return new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "fclose", array( $this->getFp() ) ) ) ;
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

    protected function translateCacheKeys($tstKeys)
    {
        $cacheKeys = array();
        foreach ( $tstKeys as $key => $value )
        {
            // Translate the 'old' variableName to the new name.
            $k = $value->accept($this);

            $type = $this->parser->symbolTable->retrieve($k->name);
            if( substr( $k->name, 0, 12) == "this->send->")
            {
                $cacheKeys[str_replace( "this->send->", "use:" , $k->name )] = $k->name;
            }
            elseif (substr( $k->name, 0, 2) == "t_" )
            {
                $cacheKeys[ "var:" . substr($k->name, 2)] = $k->name;
            }
            else
            {
                $cacheKeys[$k->name] = $k->name;
            }
        }

        return $cacheKeys;
    }

    protected function translateTTL($tstTTL)
    {
        $ttl = null;
        if ( $tstTTL !== null ) 
        {
            $ttl = $tstTTL->accept($this);
        }

        return $ttl;
    }

    protected function createCacheDir()
    {
        $dir = $this->template->configuration->compilePath . DIRECTORY_SEPARATOR . $this->template->configuration->cachedTemplatesPath;
        if ( !file_exists( $dir ) )
        {
            mkdir( $dir );
        }
    }

    protected function startCaching( $cb )
    {
        /// startCaching(); 
        $cplen = strlen( $this->parser->template->configuration->compilePath );
        if ($this->template->configuration->cacheManager !== false )
        {
            $cb->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->startCaching", array( new ezcTemplateVariableAstNode("this->template"), new ezcTemplateLiteralAstNode( $this->parser->template->stream ), new ezcTemplateVariableAstNode("_ezcTemplateCache" ), new ezcTemplateVariableAstNode("_ezcCacheKeys") ) ) ) );
        }
      
        $cb->appendStatement( $this->_fopenCacheFileWriteMode() ); // $fp = fopen( $this->cache, "w" ); 

        $cb->appendStatement( $this->_fwritePhpOpen() );                 // fwrite( $fp, "<" . "?php\n" );
        $cb->appendStatement( $this->_assignEmptyString("total" . $this->cacheLevel) );      // $total = ""
        $cb->appendStatement( $this->_assignEmptyString( self::INTERNAL_PREFIX. "output") );
    }

    // TEST VERSION for cacheblock.
    protected function startCachingCacheBlock( $cb )
    {
        /// startCaching(); 
        $cplen = strlen( $this->parser->template->configuration->compilePath );
        if ($this->template->configuration->cacheManager !== false )
        {
            $cb->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->startCaching", array( new ezcTemplateVariableAstNode("this->template"), new ezcTemplateLiteralAstNode( $this->parser->template->stream ), new ezcTemplateVariableAstNode("_ezcTemplateCache" ), new ezcTemplateVariableAstNode("_ezcCacheKeys") ) ) ) );
        }
      
        $cb->appendStatement( $this->_fopenCacheFileWriteMode() ); // $fp = fopen( $this->cache, "w" ); 

        $cb->appendStatement( $this->_fwritePhpOpen() );                 // fwrite( $fp, "<" . "?php\n" );
        //$cb->appendStatement( $this->_assignEmptyString("total") );      // $total = ""
        $cb->appendStatement( $this->_assignVariable(self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel) );
        $cb->appendStatement( $this->_assignEmptyString( self::INTERNAL_PREFIX. "output") );

    }


    protected function insertInCache( $cb, $type )
    {
        foreach ( $type->elements as $element )
        {
            $astNode = $element->accept( $this );
            if ( is_array( $astNode ) )
            {
                foreach ( $astNode as $ast )
                {
                    $cb->statements[] = $ast;
                }
            }
            else
            {
                $cb->statements[] = $astNode;
            }
        }
    }

    protected function stopCaching($cb, $addReturn = true)
    {
        $cb->appendStatement( $this->_fwriteVarExportVariable( self::INTERNAL_PREFIX . "output", true, true) );

        // $total .= $_ezcTemplate_output;
        $cb->appendStatement( $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel) );
            
        // fclose($fp);  
        $cb->appendStatement( $this->_fclose() );

        // $_ezcTemplate_output = $total;
        $cb->appendStatement( $this->_assignVariable( "total".$this->cacheLevel, self::INTERNAL_PREFIX . "output" ) );
        if ($addReturn)
        { 
            $cb->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );
        }

    }

    protected function addUseVariables()
    {
        // Add the 'use' statement, that is removed by the prepareCache walker.
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
    }

 
    public function visitProgramTstNode( ezcTemplateProgramTstNode $type )
    {
        // Is the whole template cached?
        if ($this->cacheTemplate == null)
        {
            // Call the parent instead.
            return parent::visitProgramTstNode($type);
        }

        // Cache the whole template.
        $this->cacheLevel++;


        $this->prepareProgram(); // Program operations, nothing to do with caching.

        $this->addUseVariables();
        $cacheKeys = $this->translateCacheKeys($this->cacheTemplate->keys);

        $this->addCacheKeys( $this->programNode, $cacheKeys );
            
        $ttl = $this->translateTTL($this->cacheTemplate->ttl);

        $ttlStatements = $this->checkTTL( $ttl, $cacheKeys );
        foreach ( $ttlStatements as $s )
        {
            $this->programNode->appendStatement( $s );
        }

        $this->createCacheDir();
        $this->deleteOldCache();

        // Create the if statement that checks whether the cache file exists.
        $if = new ezcTemplateIfAstNode();
        $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();

        $cb->condition = $this->notFileExistsCache();
        $cb->body = new ezcTemplateBodyAstNode();

        $this->startCaching($cb->body);
        $this->insertInCache( $cb->body, $type );

        // Create the 'else' part. The else should 'include' (and execute) the cached file. 
        $if->conditions[] = $else = new ezcTemplateConditionBodyAstNode();
        $else->body = new ezcTemplateBodyAstNode();

        $else->body->statements = array();
        $else->body->statements[] =  $this->_includeCache();


        if ($this->template->configuration->cacheManager !== false )
        {
            $cb->body->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->stopCaching", array() )));
        }

        $this->stopCaching($cb->body);
        
        // Outside.
        $this->programNode->appendStatement( $if );

        // RETURN STATEMENT outside..
        $this->programNode->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );
    }

    protected function addCacheKeys( $programNode, $cacheKeys, $cacheBlock = false )
    {
        $hasCacheKey = false;
        $programNode->appendStatement( new ezcTemplatePhpCodeAstNode( '$_ezcCacheKeys = array();' ."\n" ) );
        $cacheBlock = $cacheBlock === false ? "" : "[cb".$cacheBlock . "]";


        foreach ( $cacheKeys as $key => $value )
        {
            $programNode->appendStatement( new ezcTemplatePhpCodeAstNode( '$_ezcCacheKeys[\''.$key.'\'] = '. 'is_object( $'.$value.' ) && method_exists( $'.$value.', "cacheKey" ) ? $'.$value.'->cacheKey() : $'.  $value . ";\n" ) );

            $hasCacheKey = true;
        }

        if( $hasCacheKey )
        {
            $code = '$_ezcTemplateCache = \'' . $this->getCacheBaseName() . $cacheBlock ."'" ;
            foreach ( $cacheKeys as $key => $value )
            {
                $code .= " . '-'". '. md5( var_export( $_ezcCacheKeys[\''.$key.'\'], true ))';
            }

            $programNode->appendStatement(new ezcTemplatePhpCodeAstNode( $code . ";\n" ) );
        }
        else
        {
            $programNode->appendStatement(new ezcTemplatePhpCodeAstNode( '$_ezcTemplateCache = \'' . $this->getCacheBaseName() . $cacheBlock . "';\n" ) );
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
        $astNodes[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel);
            
        // fclose($fp);  
        $astNodes[] = $this->_fclose();

        // $_ezcTemplate_output = $total;
        $astNodes[] = $this->_assignVariable( "total".$this->cacheLevel, self::INTERNAL_PREFIX . "output" );



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
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel);

        // fwrite( $fp, "\\\<variableName> .= " . var_export( <variableName>, true) . ";" ); 
        $newStatement[] = $this->_fwriteVarExportVariable( self::INTERNAL_PREFIX . "output", true, false);

        // $_ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString( self::INTERNAL_PREFIX . "output" );

        // $output .= $_ezcTemplate_output;
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel);

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
        $newStatement[] = $this->_concatAssignVariable( self::INTERNAL_PREFIX . "output", "total".$this->cacheLevel ); 

        // $ezcTemplate_output = "";
        $newStatement[] = $this->_assignEmptyString( self::INTERNAL_PREFIX . "output" ); 

        $newStatement[] = $this->_comment(" <--- stop {/dynamic}");

        return $newStatement;
    }

    public function visitCacheTstNode( ezcTemplateCacheTstNode $type )
    {
        if ( $type->type == ezcTemplateCacheTstNode::TYPE_CACHE_TEMPLATE ) // Can be removed?
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
            //$cb = new ezcTemplateCacheBlockAstNode( $type->elements->accept($this) );
            
            return $cb;
        }
    }


    public function visitCacheBlockTstNode( ezcTemplateCacheBlockTstNode $type )
    {
        if ( $this->isInDynamicBlock )
        {
            throw new ezcTemplateParserException( $type->source, $type->endCursor, $type->endCursor, ezcTemplateSourceToTstErrorMessages::MSG_CACHE_BLOCK_IN_DYNAMIC_BLOCK );
        }

        $this->cacheLevel++;
 
        $statements = new ezcTemplateBodyAstNode();

        $cacheKeys = $this->translateCacheKeys($type->keys);

        $this->addUseVariables();
        $this->addCacheKeys( $statements, $cacheKeys, $this->cacheBlockCounter++ );
            
        $ttl = $this->translateTTL($type->ttl);

        $ttlStatements = $this->checkTTL( $ttl, $cacheKeys );
        foreach ( $ttlStatements as $s )
        {
            $statements->appendStatement( $s );
        }

        $this->createCacheDir();
        $this->deleteOldCache();

        // Create the if statement that checks whether the cache file exists.
        $if = new ezcTemplateIfAstNode();
        $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();

        $cb->condition = $this->notFileExistsCache();
        $cb->body = new ezcTemplateBodyAstNode();

        $this->startCachingCacheBlock($cb->body);
        $this->insertInCache( $cb->body, $type );

        // Create the 'else' part. The else should 'include' (and execute) the cached file. 
        $if->conditions[] = $else = new ezcTemplateConditionBodyAstNode();
        $else->body = new ezcTemplateBodyAstNode();

        $else->body->statements = array();
        $else->body->statements[] =  $this->_includeCache();


        if ($this->template->configuration->cacheManager !== false )
        {
            $cb->body->appendStatement( new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "\$this->template->configuration->cacheManager->stopCaching", array() )));
        }

        $this->stopCaching($cb->body, false);
        
        // Outside.
        $statements->appendStatement( $if );

        // RETURN STATEMENT outside..
        //$statements->appendStatement( new ezcTemplateReturnAstNode( $this->outputVariable->getAst()) );


        $this->cacheLevel--;

        return $statements->statements;

    }

}

?>
