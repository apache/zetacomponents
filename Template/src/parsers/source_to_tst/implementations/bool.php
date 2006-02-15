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
class ezcTemplateBoolSourceToTstParser extends ezcTemplateTypeSourceToTstParser
{
    /**
     * Boolean type must use lowercase characters only.
     */
    const STATE_NON_LOWERCASE = 1;

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
            $matches = $cursor->pregMatch( "#^(true|false)#i" );
            if ( $matches === false )
                return false;

            $this->status = self::PARSE_PARTIAL_SUCCESS;

            $name = $matches[0][0];
            $lower = strtolower( $name );
            if ( $name !== $lower )
            {
                $this->findNonLowercase();
                $this->operationState = self::STATE_NON_LOWERCASE;
                return false;
            }
            // $failure = "Boolean type must use lowercase characters only, got <{$name}>, expected <{$lower}>.";

            $cursor->advance( strlen( $matches[0][0] ) );
            $bool = $this->parser->createType( $this->startCursor, $cursor );
            $bool->value = $matches[0][0] == 'true' ? true : false;
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
