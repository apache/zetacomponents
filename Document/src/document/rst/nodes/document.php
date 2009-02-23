<?php
/**
 * File containing the ezcDocumentRstDocumentNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The document AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstDocumentNode extends ezcDocumentRstNode
{
    /**
     * Neting depth of document is always 0
     * 
     * @var int
     */
    public $depth = 0;

    /**
     * Construct RST document node
     * 
     * @param array $nodes
     * @return void
     */
    public function __construct( array $nodes = array() )
    {
        $this->line     = 0;
        $this->position = 0;
        $this->type     = self::DOCUMENT;
        $this->nodes    = $nodes;
    }

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $node = new ezcDocumentRstDocumentNode(
            $properties['nodes']
        );

        return $node;
    }
}

?>
