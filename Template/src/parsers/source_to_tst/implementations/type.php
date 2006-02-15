<?php
/**
 * File containing the ezcTemplateTypeSourceToTstParser class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Parser for all builtin types.
 *
 * Types are parsed by utilizing the various sub-parser for known
 * types.
 *
 * Once the type has been parsed it can be fetched by using the
 * property $value for the value and $element for the element object.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTypeSourceToTstParser extends ezcTemplateSourceToTstParser
{
    /**
     * No known type found.
     */
    const STATE_NO_KNOWN_TYPE = 1;
    /**
     * The value of the parsed type or null if nothing was parsed.
     * @var mixed
     */
    public $value;

    /**
     * The parsed element object which defines the type or null if notthing
     * was parsed.
     */
    public $element;

    /**
     * Passes control to parent.
     */
    function __construct( ezcTemplateParser $parser, /*ezcTemplateSourceToTstParser*/ $parentParser, /*ezcTemplateCursor*/ $startCursor )
    {
        parent::__construct( $parser, $parentParser, $startCursor );
        $this->value = null;
        $this->element = null;
    }

    /**
     * Parses the types by utilizing:
     * - ezcTemplateFloatSourceToTstParser for float types.
     * - ezcTemplateIntegerSourceToTstParser for integer types.
     * - ezcTemplateStringSourceToTstParser for string types.
     * - ezcTemplateBoolSourceToTstParser for boolean types.
     * - ezcTemplateArraySourceToTstParser for array types.
     */
    protected function parseCurrent( ezcTemplateCursor $cursor )
    {
        $failedParser = null;
        if ( !$cursor->atEnd() )
        {
            // Try parsing the various type types until one is found

            $failedCursor = clone $cursor;

            // @todo We should add null parser too, but only so it can give a failure back
            // to the user, since null should not be used
            $types = array( 'Float', 'Integer', 'String', 'Bool', 'Array' );
            foreach ( $types as $type )
            {
                if ( $this->parseOptionalType( $type ) )
                {
                    if ( $this->lastParser->status == self::PARSE_PARTIAL_SUCCESS )
                        return false;
                    $this->lastCursor->copy( $this->startCursor );
                    $this->value = $this->lastParser->value;
                    $this->element = $this->lastParser->element;
                    return true;
                }
            }

            $this->operationState = self::STATE_NO_KNOWN_TYPE;
        }
        return false;
    }

    protected function generateErrorMessage()
    {
        switch ( $this->operationState )
        {
            case self::STATE_NO_KNOWN_TYPE:
                return "No known type found.";
        }
        // Default error message handler.
        return parent::generateErrorMessage();
    }

    protected function generateErrorDetails()
    {
        if ( $this->operationState == self::STATE_NON_LOWERCASE )
            return "Supports types: floats, integers, strings, booleans and arrays.";
        // Default error details handler.
        return parent::generateErrorDetails();
    }
}

?>
