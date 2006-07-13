<?php
/**
 * File containing the ezcTemplateCustomBlockSourceToTstParser class
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
class ezcTemplateCustomBlockSourceToTstParser extends ezcTemplateSourceToTstParser
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

            $cb = $this->parser->createCustomBlock( $this->startCursor, $cursor );
            $cb->isClosingBlock = true;

            $this->appendElement( $cb );

            return true;
        }
 
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

        $def = ezcTemplateCustomBlockManager::getInstance()->getDefinition( $name );
        if( $def === false )
        {
            return false;
        }

        $cb = $this->parser->createCustomBlock( $this->startCursor, $cursor );
        $cb->definition = $def;
        $this->block->isNestingBlock = $def->isNestingBlock;// $requireNesting;
        $cb->isNestingBlock = $def->isNestingBlock;

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
/// TODO: 

        // @todo Make sure registered blocks are fetched from main manager.
        //$blocks = $this->getRegisteredBlocks();

        // Check if the block is registered
        if ( !isset( $blocks[$name] ) )
        {
            $this->blockName = $name;
            $names = array_keys( $blocks );

            // Check if a name with different case exists, we still do not
            // allow the parsing to continue but at least we can give a
            // friendlier and more correct error.
            foreach ( $names as $existingName )
            {
                $existingNameLower = strtolower( $existingName );
                if ( $existingNameLower === $lower )
                {
                    $this->correctBlockName = $existingName;
                    $this->operationState = self::STATE_WRONG_CASE;
                    return false;
                }
            }
            $this->operationState = self::STATE_UNKNOWN_BLOCK_NAME;
            return false;
        }

        // @todo This is just temporary code, nesting details should be up to custom block itself
        $requireNesting = $blocks[$name][0];

        // $cursor object in $block will be updated as the parser continues
        $isClosingBlock = $this->block->isClosingBlock;
        $this->block = $this->parser->createCustomBlock( $this->startCursor, $cursor );
        $this->block->isClosingBlock = $isClosingBlock;

        $cursor->advance( strlen( $matches[1][0] ) );
        $this->block->name = $name;
        $this->block->isNestingBlock = $requireNesting;

        // Now parse all parameters.
        while ( !$cursor->atEnd() )
        {
            if ( !$this->findNextElement() )
            {
                return false;
            }

            if ( $cursor->current() == "}" )
            {
                $cursor->advance();
                return true;
            }

            // Find a variable or identifier
            $elements = $this->parseSequence( array( array( 'compound' => 'or',
                                                            'compounds' => array( array( 'type' => 'Variable' ),
                                                                                  array( 'type' => 'Identifier' ) ) ) ) );
            if ( $elements === false )
            {
                $this->operationState = self::STATE_INVALID_PARAMETER;
                return false;
            }
            $this->parameterName = $elements[0]->value;
            $this->parameterNameElement = $elements[0];

            if ( $this->block->hasParameter( $this->parameterName ) )
            {
                $this->startCursor->copy( $cursor );
                $this->operationState = self::STATE_PARAMETER_ALREADY_PRESENT;
                return false;
            }

            if ( !$this->findNextElement() )
            {
                return false;
            }

            $matches = $cursor->pregMatchComplete( "#^(=)(?:[^=])#" );
            if ( $matches === false )
            {
                $this->operationState = self::STATE_WRONG_ASSIGNMENT;
                return false;
            }
            $cursor->advance( strlen( $matches[1][0] ) );

            $parser = new ezcTemplateExpressionSourceToTstParser( $this->parser, $this, null );
            if ( !$this->parseRequiredType( $parser ) )
            {
                $this->lastParser = null;
                $this->operationState = self::STATE_WRONG_EXPRESSION;
                return false;
            }

            $this->block->appendParameter( $this->parameterName, $this->parameterNameElement, $this->lastParser->rootOperator );

            if ( !$this->findNextElement() )
            {
                return false;
            }

            // Handle next parameter
        }

        return false;
    }

    
    /*
    const STATE_WRONG_CASE = 1;

    const STATE_UNKNOWN_BLOCK_NAME = 2;

    const STATE_INVALID_PARAMETER = 3;

    const STATE_WRONG_ASSIGNMENT = 4;

    const STATE_WRONG_EXPRESSION = 5;

    const STATE_PARAMETER_ALREADY_PRESENT = 6;
     */

    /*
    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_WRONG_CASE:
                return "Name of block must use use exact same case as the registered name.";
            case self::STATE_UNKNOWN_BLOCK_NAME:
                return "Unknown block <{$this->blockName}>.";
            case self::STATE_INVALID_PARAMETER:
                return "Invalid parameter for block.";
            case self::STATE_WRONG_ASSIGNMENT:
                return "Wrong assignment marker used, should be one equal sign =.";
            case self::STATE_WRONG_EXPRESSION:
                return "Wrong expression for parameter.";
            case self::STATE_PARAMETER_ALREADY_PRESENT:
                return "The parameter <{$this->parameterName}> has already been set for the block, cannot override value.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_WRONG_CASE:
                return "Correct name of block is <{$this->correctBlockName}> while <{$this->blockName}> was tried.";
            case self::STATE_UNKNOWN_BLOCK_NAME:
                $blocks = $this->getRegisteredBlocks();
                return "Available blocks types are: " . join( ", ", array_keys( $blocks ) );
            case self::STATE_WRONG_ASSIGNMENT:
                return "";
            case self::STATE_WRONG_EXPRESSION:
                return "";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
     */
}

?>
