<?php
/**
 * File containing the ezcDocumentRstLiteralBlockNode struct
 *
 * @package LiteralBlock
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The literal block AST node
 * 
 * @package LiteralBlock
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
class ezcDocumentRstLiteralBlockNode extends ezcDocumentRstNode
{
    

    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @param array $nodes
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, array $nodes = array() )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::LITERAL_BLOCK );
        $this->nodes = $nodes;
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return 'CDATA';
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
        return new ezcDocumentRstLiteralBlockNode(
            $properties['token'],
            $properties['nodes']
        );
    }
}

?>
