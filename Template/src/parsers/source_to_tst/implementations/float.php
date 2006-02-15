<?php
/**
 * File containing the ezcTemplateFloatSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for float types.
 *
 * Floats are defined in the same way as in PHP.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateFloatSourceToTstParser extends ezcTemplateTypeSourceToTstParser
{
    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
    }

    /**
     * Parses the float types by looking for float expression.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        if ( !$cursor->atEnd() )
        {
            $matches = $cursor->pregMatch( "#^-?[0-9]*\\.[0-9]+#" );
            if ( $matches !== false )
            {
                $cursor->advance( strlen( $matches[0][0] ) );
                $float = $this->parser->createType( $this->startCursor, $cursor );
                $float->value = (float)$matches[0][0];
                $this->value = $float->value;
                $this->element = $float;
                $this->appendElement( $float );
                return true;
            }
        }
        return false;
    }

    public function getTypeName()
    {
        return "float";
    }
}

?>
