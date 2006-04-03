<?php
/**
 * File containing the ezcTemplateArrayRangeSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateArrayRangeSourceToTstParser extends ezcTemplateLiteralSourceToTstParser
{

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Look ahead: <literal> .. 
     * 
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $this->findNextElement();

        if ( !$this->parseOptionalType( 'Integer', null, false ) )
        {
            echo ("no1");
            return false;
        }

        $range1 = $this->lastParser->value;

        $this->findNextElement();
        if( !$cursor->match("..") )
        {
            return false;
        }

        $this->findNextElement();
        if( !$this->parseOptionalType( 'Integer', null, false ) )
        {
            throw new ezcTemplateSourceToTstParserException( $this, $cursor, ezcTemplateSourceToTstErrorMessages::MSG_EXPECT_LITERAL); 
        }

        // We got a match..

        $range2 = $this->lastParser->value;

        $arrayRange = $this->parser->createArrayRange( $this->startCursor, $cursor );
        $arrayRange->appendParameter( $range1 );
        $arrayRange->appendParameter( $range2 );

        return true;
    }

    public function getTypeName()
    {
        return "array_range";
    }
}

?>
