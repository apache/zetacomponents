<?php
/**
 * File containing the ezcTemplateStringSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for string types.
 *
 * Strings are defined in the same way as in PHP, however the double quoted
 * strings cannot have references to PHP variables inside them.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateStringSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the string types by looking for single or double quotes to start
     * the string.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $char = $cursor->current();
            if ( $char == '"' ||
                 $char == "'" )
            {
                $cursor->advance();
                $this->status = self::PARSE_PARTIAL_SUCCESS;

                $nextChar = $cursor->current();
                if ( $nextChar === $char )
                {
                    $string = $this->parser->createLiteral( $this->startCursor, $cursor );
                    // We know it is an empty string, no need to extract
                    $str = "";
                    $string->value = $str;
                    $this->value = $string->value;
                    $this->element = $string;
                    $this->appendElement( $string );
                    $cursor->advance();
                    return true;
                }
                else
                {
                    $matches = $cursor->pregMatchComplete( "#((?!\\\\)[^{$char}])+{$char}#" );
                    if ( $matches === false )
                        return false;

                    $cursor->advance( $matches[0][1] + strlen( $matches[0][0] ) );
                    $string = $this->parser->createLiteral( $this->startCursor, $cursor );
                    $str = (string)$this->startCursor->subString( $cursor->position );
                    $str = substr( $str, 1, -1 );
                    $str = str_replace( array( "\\\"", "\\\'", "\\\\" ),
                                        array( '"',    "'",    "\\" ),
                                        $str );
                    $string->value = $str;
                    $this->value = $string->value;
                    $this->element = $string;
                    $this->appendElement( $string );
                    return true;
                }
            }
        }
        return false;
    }

    public function getTypeName()
    {
        return "string";
    }
}

?>
