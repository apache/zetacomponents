<?php
/**
 * File containing the ezcTemplateCacheSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for custom template blocks following a generic syntax.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCacheSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->block = null;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        /*
        if ( $this->block->isClosingBlock )
        {
            $this->findNextElement();

            $matches = $cursor->pregMatchComplete( "#^([a-zA-Z_][a-zA-Z0-9_-]*)(?:[^a-zA-Z])#i" );
            if ( $matches === false )
                return false;

            $name = $matches[1][0];
            $cursor->advance( strlen( $name ) );
            $this->findNextElement( $cursor );

            if( !$cursor->match( "}" ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_CURLY_BRACE_CLOSE );
            }

            $cb = new ezcTemplateCustomBlockTstNode( $this->parser->source, $this->startCursor, $cursor );

            $cb->isClosingBlock = true;

            $this->appendElement( $cb );
            return true;
        }
         */
 
        if( $cursor->match( "cache_template" ) )
        {
            $cacheNode = new ezcTemplateCacheTstNode( $this->parser->source, $this->startCursor, $cursor );

            //$cacheNode->isClosingBlock = false;
            $cacheNode->templateCache = true;
            $this->appendElement( $cacheNode);
            
            $this->findNextElement( $cursor );

            if( !$cursor->match( "}" ) ) 
            {
                die ("Expected an '}' at the end of 'cache_template'");
            }

            return true;
            // Need to cache the template
        }





        return false;
        
        // Check for the name of the custom block
        // Note: The code inside the ( ?: ) brace ensures that the next character
        // is not an alphabetical character ie. a word boundary
        $matches = $cursor->pregMatchComplete( "#^([a-zA-Z_][a-zA-Z0-9_-]*)(?:[^a-zA-Z])#i" );
        if ( $matches === false )
        {
            return false;
        }
       
        $name = $matches[1][0];

        $cursor->advance( strlen( $name ) );
        $this->findNextElement( $cursor );

        //$def = ezcTemplateCustomBlockManager::getInstance()->getDefinition( $name );

        $def = $this->getCustomBlockDefinition( $name );

        if( $def === false )
        {
            return false;
        }

        $cb = new ezcTemplateCustomBlockTstNode( $this->parser->source, $this->startCursor, $cursor );
        $cb->definition = $def;
        $this->block->isNestingBlock = $cb->isNestingBlock = $def->hasCloseTag;

        if( isset( $def->startExpressionName ) && $def->startExpressionName != "" )
        {
            if( !in_array( $def->startExpressionName, $def->optionalParameters ) && !in_array( $def->startExpressionName, $def->requiredParameters ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                    sprintf( ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_REQUIRED_OR_OPTIONAL_PARAMETER_DEFINITION_IN_CUSTOM_BLOCK, $def->startExpressionName ) );
            }

            if ( !$this->parseOptionalType( 'Expression', null, false ) )
            {
                if( in_array( $def->startExpressionName, $def->requiredParameters ) )
                {
                    throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
                }
            }
            else
            {
                $cb->namedParameters[ $def->startExpressionName ] = $this->lastParser->rootOperator;
                $this->findNextElement( $cursor );
            }
        }

        while( !$cursor->match( "}" ) )
        {
            $match = $cursor->pregMatch( "#^[a-zA-Z_][a-zA-Z0-9_-]*#");
            if( !$match )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                   sprintf(  ezcTemplateSourceToTstErrorMessages::MSG_UNEXPECTED_TOKEN, $cursor->current( 1 ) ) );
 
            }

            if( !in_array( $match, $def->optionalParameters ) && !in_array( $match, $def->requiredParameters ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                    sprintf(  ezcTemplateSourceToTstErrorMessages::MSG_UNKNOWN_CUSTOM_BLOCK_PARAMETER, $match) );
            }

            if ( array_key_exists( $match, $cb->namedParameters )  )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                    sprintf( ezcTemplateSourceToTstErrorMessages::MSG_REASSIGNMENT_CUSTOM_BLOCK_PARAMETER, $match ) );
            }

            $this->findNextElement( $cursor );
            // The '=' is optional.
            if( $cursor->match( "=" ) )
            {
                $this->findNextElement( $cursor );
            }

            // The parameter has an expression.
            if ( !$this->parseOptionalType( 'Expression', null, false ) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_EXPRESSION );
            }
     
            // Append the parameter to the "namedParameters" array.
            $cb->namedParameters[ $match ] = $this->lastParser->rootOperator;
        }

        // Check if all requiredParameters are set.
        foreach( $def->requiredParameters as  $val )
        {
            if( !array_key_exists( $val, $cb->namedParameters) )
            {
                throw new ezcTemplateParserException( $this->parser->source, $this->startCursor, $this->currentCursor, 
                    sprintf(  ezcTemplateSourceToTstErrorMessages::MSG_MISSING_CUSTOM_BLOCK_PARAMETER, $val ) );
            }
        }

        $this->appendElement( $cb );

        return true;
    }
}

?>
