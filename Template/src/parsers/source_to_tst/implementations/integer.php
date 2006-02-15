<?php
/**
 * File containing the ezcTemplateIntegerSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for integer types.
 *
 * Integers are defined in the same way as in PHP.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateIntegerSourceToTstParser extends ezcTemplateTypeSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the integer types by looking for numerical characters.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $matches = $cursor->pregMatch( "#^-?[0-9]+#" );
            if ( $matches !== false )
            {
                $cursor->advance( strlen( $matches[0][0] ) );
                $integer = $this->parser->createType( $this->startCursor, $cursor );
                $integer->value = (int)$matches[0][0];
                $this->value = $integer->value;
                $this->element = $integer;
                $this->appendElement( $integer );
                return true;
            }
        }
        return false;
    }

    public function getTypeName()
    {
        return "integer";
    }
}

?>
