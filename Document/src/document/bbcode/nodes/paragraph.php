<?php
/**
 * File containing the ezcDocumentBBCodeParagraphNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for BBCode document paragraph abstract syntax tree nodes
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentBBCodeParagraphNode extends ezcDocumentBBCodeNode
{
    /**
     * Set state after var_export
     *
     * @param array $properties
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $nodeClass = __CLASS__;
        $node = new $nodeClass( $properties['token'] );
        $node->nodes = $properties['nodes'];
        return $node;
    }
}

?>
