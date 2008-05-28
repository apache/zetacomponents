<?php
/**
 * File containing the ezcDocumentRstLineBlockNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The line block AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstLineBlockNode extends ezcDocumentRstNode
{
    /**
     * LineBlock indentation level
     * 
     * @var int
     */
    public $indentation;

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
        parent::__construct( $token, self::LINE_BLOCK );
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return $this->indentation;
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
        $node = new ezcDocumentRstLineBlockNode(
            $properties['token']
        );

        $node->nodes       = $properties['nodes'];
        $node->indentation = $properties['indentation'];
        return $node;
    }
}

?>
