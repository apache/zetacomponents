<?php
/**
 * File containing the ezcDocumentWikiBlockquoteNode struct
 *
 * @package Blockquote
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document abstract syntax tree blockquote nodes
 * 
 * @package Blockquote
 * @version //autogen//
 */
class ezcDocumentWikiBlockquoteNode extends ezcDocumentWikiLineLevelNode
{
    /**
     * Blockquote indentation level
     * 
     * @var int
     */
    public $level = 1;

    /**
     * Construct Wiki node
     * 
     * @param ezcDocumentWikiToken $token
     * @param int $type 
     * @return void
     */
    public function __construct( ezcDocumentWikiToken $token )
    {
        parent::__construct( $token );

        if ( $token instanceof ezcDocumentWikiParagraphIndentationToken )
        {
            $this->level = $token->level;
        }
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
        $nodeClass = __CLASS__;
        $node = new $nodeClass( $properties['token'] );
        $node->nodes = $properties['nodes'];
        return $node;
    }
}

?>
