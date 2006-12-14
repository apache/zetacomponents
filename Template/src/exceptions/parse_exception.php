<?php
/**
 * File containing the ezcTemplateParseException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception for problems when renaming template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateParseException extends ezcTemplateException
{
    /**
     * No source code was found in source object.
     */
    const NO_SOURCE_CODE = 1;

    /**
     * The element passed to the program parser is not valid at the program context.
     */
    const INVALID_PROGRAM_ELEMENT = 2;

    /**
     * Initialises the exception with the original template file path and the new file path.
     *
     * @param string $from The original file path.
     * @param string $to The new file path.
     */
    public function __construct( $type, $comment = false )
    {
        switch ( $type )
        {
            case self::NO_SOURCE_CODE:
                $message = "No source code found in the source object, cannot parse it.";
                break;
            case self::INVALID_PROGRAM_ELEMENT:
                $message = "The element '{$comment}' passed to the program parser is not valid at the program context.\nIf the element is meant to be handled at the program level it must make sure it inherits ezcTemplateBlockTstNode,\n if not it is most likely an incorrect type passed from an element parser.";
                break;
        }
        parent::__construct( $message );
    }
}
?>
