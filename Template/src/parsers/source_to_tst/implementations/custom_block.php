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
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateCustomBlockSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Name of block does not use same case as registered name of block.
     */
    const STATE_WRONG_CASE = 1;

    /**
     * Block is not a registered block type.
     */
    const STATE_UNKNOWN_BLOCK_NAME = 2;

    /**
     * Invalid parameter for custom block.
     */
    const STATE_INVALID_PARAMETER = 3;

    /**
     * Wrong assignment marker used for parameter.
     */
    const STATE_WRONG_ASSIGNMENT = 4;

    /**
     * Wrong expression for parameter.
     */
    const STATE_WRONG_EXPRESSION = 5;

    /**
     * The parameter has already been set for the block.
     */
    const STATE_PARAMETER_ALREADY_PRESENT = 6;

    /**
     * Passes control to parent.
    */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->block = null;
    }

    /**
     * Returns true if the current character is a curly bracket (}) which means
     * the end of the block.
     */
    public function atEnd( ezcTemplateCursor $cursor, /*ezcTemplateTstNode*/ $operator, $finalize = true )
    {
        // Check for end of block
        if ( $cursor->current() == '}' )
        {
            return true;
        }
        // Check for parameter assignment
        if ( $cursor->pregMatchComplete( "#^[$]?[a-zA-Z_][a-zA-Z0-9_]*[ \t\r\n]*=[^=]#" ) )
        {
            return true;
        }
        return false;
    }

    /**
     * Parses the expression by using the ezcTemplateExpressionSourceToTstParser class.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( $this->parser->debug )
            echo "Starting custom block\n";

        // Check for the name of the custom block
        // Note: The code inside the (?:) brace ensures that the next character
        // is not an alphabetical character ie. a word boundary
        $matches = $cursor->pregMatchComplete( "#^([a-zA-Z_][a-zA-Z0-9_-]*)(?:[^a-zA-Z])#i" );

        if ( $matches === false )
            return false;

        $this->status = self::PARSE_PARTIAL_SUCCESS;
        $name = $matches[1][0];
        $lower = strtolower( $name );

        // @todo Make sure registered blocks are fetched from main manager.
        $blocks = $this->getRegisteredBlocks();

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

    /**
     * @todo Make sure registered blocks are fetched from main manager.
     */
    protected function getRegisteredBlocks()
    {
        return array( 'section' => array( true ),
//                      'section-else' => array( true ),
                      'include' => array( false ),
                      'let' => array( true ),
                      'set' => array( false ),
                      'tool_bar' => array( false ),
                      'include' => array( false ),
                      'ldelim' => array( false ),
                      'rdelim' => array( false ) );
    }

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
}

?>
