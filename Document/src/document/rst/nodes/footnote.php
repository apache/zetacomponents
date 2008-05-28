<?php
/**
 * File containing the ezcDocumentRstFootnoteNode struct
 *
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The footnote AST node
 * 
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
class ezcDocumentRstFootnoteNode extends ezcDocumentRstNode
{
    /**
     * Footnote target name
     * 
     * @var array
     */
    public $name;

    /**
     * Footnote number
     * 
     * @var int
     */
    public $number;

    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token
     * @param array $name
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, array $name )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::FOOTNOTE );
        $this->name = $name;
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
        $node = new ezcDocumentRstFootnoteNode(
            $properties['token'],
            $properties['name']
        );

        $node->nodes  = $properties['nodes'];
        return $node;
    }
}

?>
