<?php

/**
 * File containing the ezcDocumentDocbookElementVisitorConverter class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Basic converter which stores a list of handlers for each node in the docbook
 * element tree. Those handlers will be executed for the elements, when found.
 * The handler can then handle the repective subtree.
 *
 * Additional handlers may be added by the user to the converter class.
 * 
 * @package Document
 * @version //autogen//
 */
abstract class ezcDocumentDocbookToRstBaseHandler extends ezcDocumentDocbookElementVisitorHandler
{
    protected function wordWrap( ezcDocumentDocbookToRstConverter $converter, $text, $indentation = 0 )
    {
        $text = wordwrap( $text, $converter->options->wordWrap - $indentation, "\n" );

        // Apply indentation to text
        $indentationString = str_repeat( ' ', $indentation );
        $text = $indentationString . str_replace( "\n", "\n" . $indentationString, $text );

        return $text;
    }
}

?>
