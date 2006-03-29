<?php
/**
 * File containing the ezcTemplateVariableSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for variable definitions.
 *
 * Variables are defined in the same way as in PHP.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateVariableSourceToTstParser extends ezcTemplateSourceToTstParser
{
 
    /**
     * The variable declaration is missing an identifier.
     */
    const STATE_NO_IDENTIFIER = 1;

    /**
     * The variable declaration contains a namespace marker, this is not allowed.
     */
    const STATE_INVALID_NAMESPACE_MARKER = 2;

    /**
     * The variable declaration contains a namespace-root marker, this is not allowed.
     */
    const STATE_INVALID_NAMESPACE_ROOT_MARKER = 3;

    const MSG_INVALID_VARIABLE              = "The variable name is invalid.";
    const LNG_INVALID_IDENTIFIER            = "Invalid identifier";

    const LNG_INVALID_NAMESPACE_ROOT_MARKER = "The namespace-root marker (#) was used in the template engine of eZ publish 3.x but it's no longer allowed.";
    const LNG_INVALID_NAMESPACE_MARKER      = "The namespace marker (:) was used in template engine in eZ publish 3.x but is no longer allowed.";

    /**
     * The variable name which was found while parsing or null if no variable
     * has been found yet.
     * @var string
     */
    public $variableName;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->variable = null;
        $this->variableName = null;
    }

    /**
     * Parses the variable types by looking for a dollar sign followed by an
     * identifier. The identifier is parsed by using ezcTemplateIdentifierSourceToTstParser.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            if ( $cursor->match('$') )
            {
                $this->status = self::PARSE_PARTIAL_SUCCESS;

                if ( $cursor->current() == '#' )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_INVALID_VARIABLE, self::LNG_INVALID_NAMESPACE_ROOT_MARKER);
                }

                if ( $cursor->current() == ':' )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_INVALID_VARIABLE, self::LNG_INVALID_NAMESPACE_MARKER);
                }

                if ( !$this->parseRequiredType( 'Identifier', null, false ) )
                {
                    throw new ezcTemplateSourceToTstParserException( $this, $cursor, self::MSG_INVALID_VARIABLE, self::LNG_INVALID_IDENTIFIER );
                    return false;
                }

                $this->variableName = $this->lastParser->identifierName;

                $variable = $this->parser->createVariable( $this->startCursor, $cursor );
                $variable->name = $this->variableName;
                $this->element = $variable;
                $this->appendElement( $variable );
                return true;
            }
        }
        return false;
    }
    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_IDENTIFIER:
                return "The variable declaration is missing an identifier.";
            case self::STATE_INVALID_NAMESPACE_MARKER:
                return "The variable declaration contains a namespace marker, this is not allowed.";
            case self::STATE_INVALID_NAMESPACE_ROOT_MARKER:
                return "The variable declaration contains a namespace-root marker, this is not allowed.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        $text = '';
        switch ( $this->operationState )
        {
            case self::STATE_INVALID_NAMESPACE_MARKER:
                $text = "The namespace marker (:) was used in template engine in eZ publish 3.x but is no longer allowed.\n";
                break;
            case self::STATE_INVALID_NAMESPACE_ROOT_MARKER:
                $text = "The namespace-root marker (#) was used in template engine in eZ publish 3.x but is no longer allowed.\n";
                break;
        }

        // Add the general text
        switch ( $this->operationState )
        {
            case self::STATE_NO_IDENTIFIER:
            case self::STATE_INVALID_NAMESPACE_MARKER:
            case self::STATE_INVALID_NAMESPACE_ROOT_MARKER:
                return $text . "Accepted values are: dollar sign followed by alpha-numeric characters and/or underscores.";
        }
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
