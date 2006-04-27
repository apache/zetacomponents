<?php
/**
 * File containing the ezcTemplateControlStructureSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for template blocks containing an expression only.
 *
 * Parses inside the blocks {...} and looks for an expression by using the
 * ezcTemplateExpressionSourceToTstParser class.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateControlStructureSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * Control structures must use lowercase characters only.
     */
    const STATE_NON_LOWERCASE = 1;

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
        if ( $cursor->current() == '}' )
        {
            if ( !$finalize )
                return true;

            // reached end of expression
            $cursor->advance( 1 );
            $this->block->endCursor = clone $this->block->endCursor;
            $this->appendElement( $this->block );
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
            echo "Starting control structure\n";

        // Check if any control structure names are used.
        // Note: The code inside the (?:) brace ensures that the next character
        // is not an alphabetical character ie. a word boundary
        $matches = $cursor->pregMatchComplete( "#^(foreach|while|if|elseif|else|switch|case|default|include|return|embed|break|continue|skip|delimiter|increment|decrement|reset|once|def|undef|set)(?:[^a-zA-Z])#i" );

        if ( $matches === false )
            return false;

        $this->status = self::PARSE_PARTIAL_SUCCESS;
        $name = $matches[1][0];
        $lower = strtolower( $name );
        if ( $name !== $lower )
        {
            $this->findNonLowercase();
            $this->operationState = self::STATE_NON_LOWERCASE;
            return false;
        }

        $cursor->advance( strlen( $matches[1][0] ) );

        // control structure map
        $csMap = array();
        $csMap['foreach'] = 'ForeachLoop';
        $csMap['for'] = 'ForLoop';
        $csMap['while'] = 'WhileLoop';
        $csMap['if'] = 'IfCondition';
        $csMap['elseif'] = 'IfCondition';
        $csMap['else'] = 'IfCondition';
        $csMap['switch'] = 'SwitchCondition';
        $csMap['case'] = 'SwitchCondition';
        $csMap['default'] = 'SwitchCondition';
        $csMap['include'] = 'Include';
        $csMap['return'] = 'Include';
        $csMap['embed'] = 'Include';
        $csMap['break'] = 'Loop';
        $csMap['continue'] = 'Loop';
        $csMap['skip'] = 'Delimiter';
        $csMap['delimiter'] = 'Delimiter';
        $csMap['increment'] = 'Cycle';
        $csMap['decrement'] = 'Cycle';
        $csMap['reset'] = 'Cycle';
        $csMap['once'] = 'Once';
        $csMap['def'] = 'Def';

        // tmp
        if ( !isset( $csMap[$name] ) )
        {
            $this->status = self::PARSE_FAILURE;
            return false;
        }

        $parser = 'ezcTemplate' . $csMap[$name] . 'SourceToTstParser';

        // tmp
        if ( !class_exists( $parser ) )
        {
            $this->status = self::PARSE_FAILURE;
            return false;
        }

        // @todo Fix exception class
        if ( !class_exists( $parser ) )
            throw new Exception( "Requested parser class <{$parser}> does not exist" );


        $controlStructureParser = new $parser( $this->parser, $this, null );
        $this->block->name = $name;
        $controlStructureParser->block = $this->block;
        if ( !$this->parseRequiredType( $controlStructureParser ) )
        {
            return false;
        }
        return true;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NON_LOWERCASE:
                return "Control structures must use lowercase characters only.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NON_LOWERCASE:
                return "Available control structures are: foreach, for, while, if, elseif, else, switch, case, include, embed, break, continue, skip, delimiter, once, def";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
