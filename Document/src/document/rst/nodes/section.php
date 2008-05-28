<?php
/**
 * File containing the ezcDocumentRstSectionNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The document section AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstSectionNode extends ezcDocumentRstNode
{
    /**
     * Section title
     * 
     * @var string
     */
    public $title;

    /**
     * Depth of section nesting
     * 
     * @var int
     */
    public $depth;

    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @param int $depth
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, $depth = 0 )
    {
        parent::__construct( $token, self::SECTION );

        $this->title = $token->content;
        $this->depth = $depth;
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return trim( $this->token->content );
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
        $node = new ezcDocumentRstSectionNode(
            $properties['token'],
            $properties['depth']
        );

        $node->nodes = $properties['nodes'];

        return $node;
    }
}

?>
