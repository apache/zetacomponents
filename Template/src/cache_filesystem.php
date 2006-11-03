<?php

class ezcTemplateCacheFilesystem
{
    private $config = null;

    private $keys = array();
    private $ttl = null;
    private $stream = null;

    private $cacheBaseName = null;

    public function __construct( ezcTemplateConfiguration $config )
    {
        $this->config = $config; 
    }

    protected function getCacheBaseName()
    {
        if( $this->cacheBaseName === null )
        {
            $rpTemplate = realpath( $this->config->templatePath );
            $rpStream = realpath( $this->stream );

            if( strncmp( $rpTemplate, $rpStream, strlen( $rpTemplate ) ) == 0 )
            { 
                $fileName = substr( $rpStream, strlen( $rpTemplate ) );
            }
            else
            {
                $fileName = $rpStream;
            }

            $this->cacheBaseName = $this->config->compilePath . DIRECTORY_SEPARATOR . $this->config->cachedTemplatesPath . DIRECTORY_SEPARATOR . str_replace( '/', "-", $fileName ); 
        }

        return $this->cacheBaseName;
    }



    protected function createCacheVariable()
    {
        $code = '$_ezcTemplateCache = \'' . $this->getCacheBaseName() ."'"; 

        $st = ezcTemplateSymbolTable::getInstance();

        foreach( $this->keys as $key )
        {
            $code .=  '.\'-\'. md5( var_export( $'.  $key . ', true ) ) ';
        }

        $code .= ";\n";

        return new ezcTemplatePhpCodeAstNode( $code );
    }

    /**
     *  Returns the ast tree:  !file_exists( [ $_ezcTemplateCache ] )
     */
    protected function notFileExistsCache()
    {
        return new ezcTemplateLogicalNegationOperatorAstNode( new ezcTemplateFunctionCallAstNode( "file_exists", array( new ezcTemplateVariableAstNode( "_ezcTemplateCache" ) ) ) );
    }



    /** 
     * The last statement MUST be a part that is a condition which is inside an if-statement.
     */
    public function getCacheExists( )
    {
        $statements = array();

        // Create the variable.
        $statements[] = $this->notFileExistsCache();

        return $statements;
    }


    // XXX: Return cache data.
    public function getCacheFileName()
    {
        return new ezcTemplateVariableAstNode( "_ezcTemplateCache" );
    }


    public function checkTTL()
    {
        $statements = array();

        $statements[] = $this->createCacheVariable();


        if( $this->ttl !== null )
        {
            // Create the if statement that checks whether the cache file exists.
            $if = new ezcTemplateIfAstNode();
            $if->conditions[] = $cb = new ezcTemplateConditionBodyAstNode();


            $time = new ezcTemplateFunctionCallAstNode( "time", array() );
            $time->checkAndSetTypeHint();
            
            // if( file_exists( \$_ezcTemplateCache ) && filemtime( \$_ezcTemplateCache ) + ( /*[ TTL ]*/ ) < time() )
            // {
            //     echo 'REMOVE THE FILE';
            //     //unlink( [FILE] )
            // }\n" );

            $cb->condition = new ezcTemplateLogicalAndOperatorAstNode( new ezcTemplateFunctionCallAstNode( "file_exists", array( $this->getCacheFileName() ) ), new ezcTemplateLessThanOperatorAstNode( new ezcTemplateAdditionOperatorAstNode( new ezcTemplateFunctionCallAstNode( "filemtime", array( $this->getCacheFileName() )),  new ezcTemplateParenthesisAstNode( $this->ttl )  ) , $time ) );

            $cb->body = new ezcTemplateBodyAstNode();

            $cb->body->statements = array();
            
            $cb->body->statements[] = new ezcTemplateGenericStatementAstNode( new ezcTemplateFunctionCallAstNode( "unlink", array( $this->getCacheFileName() ) ) );

            $statements[] = $if;
        }

        return $statements;
    }



    /** 
     * Back to the good old set method, because using an array as a property is broken in PHP. 
     */
    public function setCacheKeys( $values )
    {
        $this->keys = $values;
    }  

    public function setTTL( $value )
    {
        $this->ttl = $value;
    }

    public function setStream( $value )
    {
        $this->stream = $value;
    }

    protected function deleteOldCache()
    {
        $bn = $this->getCacheBaseName();

        $base = basename( $bn );
        $dir = dirname( $bn); 

        if( is_dir( $dir ) )
        {
            $dp = opendir( $dir );
            while ( false !== ( $file = readdir( $dp ) ) )
            {
                if( strncmp( $base, $file, strlen($base ) ) == 0 ) 
                {
                    unlink( $dir . DIRECTORY_SEPARATOR . $file );
                }
            }

            closedir( $dp );
        }
    }

    public function initializeCache()
    {

        $dir = $this->config->compilePath . DIRECTORY_SEPARATOR . $this->config->cachedTemplatesPath;

        if( !file_exists( $dir ) )
        {
            mkdir( $dir );
        }
        
        // Create a cache directory, if needed.
        $this->deleteOldCache();

    }
}
?>
