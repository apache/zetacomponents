<?php
/**
 * File containing the ezcDocumentWikiTitleNode struct
 *
 * @package Title
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document abstract syntax tree title nodes
 * 
 * @package Title
 * @version //autogen//
 */
class ezcDocumentWikiTitleNode extends ezcDocumentWikiLineLevelNode
{
    /**
     * Heading level
     * 
     * @var int
     */
    public $level;

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
        $this->level = $token->level;
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

        // Set additional node values
        // $node->indentation = $properties['indentation'];

        return $node;
    }
}

?>
