<?php
/**
 * File containing the ezcDocumentRstMarkupInlineLiteralNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The inline literal markup node AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstMarkupInlineLiteralNode extends ezcDocumentRstNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        parent::__construct( $token, self::MARKUP_LITERAL );
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
        $node = new ezcDocumentRstMarkupInlineLiteralNode(
            $properties['token']
        );

        $node->nodes = $properties['nodes'];
        return $node;
    }
}

?>
