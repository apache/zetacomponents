<?php
/**
 * File containing the ezcTemplateNullSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Parser for null types.
 *
 * Floats are defined in the same way as in PHP.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateNullSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }


    /**
     * Parses the null type.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            if ( $cursor->match( "null" ) )
            {
                $literal = new ezcTemplateLiteralTstNode( $this->parser->source, $this->startCursor, $cursor );
                $literal->value = null;
                $this->element = $literal;
                $this->appendElement( $literal );
                return true;
            } 
       }
       return false;
    }
 
    public function getTypeName()
    {
        return "null";
    }
}

?>
