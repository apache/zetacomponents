<?php
/**
 * File containing the ezcTemplateBoolSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for boolean types.
 *
 * Booleans are defined in the same way as in PHP.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateBoolSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
{
    /**
     * Boolean type must use lowercase characters only.
     */
    const STATE_NON_LOWERCASE = 1;

    const MSG_NON_LOWERCASE_BOOLEAN  = "Boolean type must use lowercase characters only.";
    const LNG_ALLOWED_BOOLEANS       = "Acceptable values are: 'true' or 'false'";

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the boolean types by looking for either 'true' or 'false'.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            // @todo This should check that there is no alphabetical characters
            //       after the true|false.
            $matches = $cursor->pregMatchComplete( "#^(true|false)(?:\W)#i" );
            if ( $matches === false )
                return false;

            $name = $matches[1][0];
            $this->status = self::PARSE_PARTIAL_SUCCESS;

            $lower = strtolower( $name );
            if ( $name !== $lower )
            {
                $this->findNonLowercase();
                throw new ezcTemplateSourceToTstParserException( $this, $this->currentCursor, self::MSG_NON_LOWERCASE_BOOLEAN, self::LNG_ALLOWED_BOOLEANS ); 
            }

            $cursor->advance( strlen( $name ) );
            $bool = $this->parser->createLiteral( $this->startCursor, $cursor );
            $bool->value = $name == 'true';
            $this->value = $bool->value;
            $this->element = $bool;
            $this->appendElement( $bool );
            return true;
        }
        return false;
    }

    protected function generateErrorMessage()
    {
        if ( $this->operationState == self::STATE_NON_LOWERCASE )
            return "Boolean type must use lowercase characters only.";
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        if ( $this->operationState == self::STATE_NON_LOWERCASE )
            return "Acceptable values are: true | false";
        // Default error details handler.
        return parent::generateErrorDetails();
    }

    public function getTypeName()
    {
        return "boolean";
    }
}

?>
