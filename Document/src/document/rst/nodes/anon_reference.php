<?php
/**
 * File containing the ezcDocumentRstAnonymousReferenceNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The AST node for anonymous hyperlink references
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstAnonymousReferenceNode extends ezcDocumentRstNode
{
    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::ANON_REFERENCE );
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
        $node = new ezcDocumentRstAnonymousReferenceNode(
            $properties['token']
        );

        $node->nodes = $properties['nodes'];
        return $node;
    }
}

?>
