<?php
/**
 * File containing the ezcDocumentRstTargetNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The internal target AST node
 *
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstTargetNode extends ezcDocumentRstNode
{
    /**
     * Construct RST document node
     *
     * @param ezcDocumentRstToken $token
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        parent::__construct( $token, self::TARGET );
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
        $node = new ezcDocumentRstTargetNode(
            $properties['token']
        );

        $node->nodes  = $properties['nodes'];
        return $node;
    }
}

?>
