<?php
/**
 * File containing the ezcDocumentRstReferenceNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The external reference AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstReferenceNode extends ezcDocumentRstLinkNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        parent::__construct( $token, self::REFERENCE );
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
        $node = new ezcDocumentRstReferenceNode(
            $properties['token']
        );

        $node->nodes  = $properties['nodes'];
        return $node;
    }
}

?>
