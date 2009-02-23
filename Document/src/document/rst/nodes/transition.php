<?php
/**
 * File containing the ezcDocumentRstTransitionNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The AST node for document transitions
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstTransitionNode extends ezcDocumentRstNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        parent::__construct( $token, self::TRANSITION );
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
        $node = new ezcDocumentRstTransitionNode(
            $properties['token']
        );

        return $node;
    }
}

?>
