<?php
/**
 * File containing the ezcDocumentRstTableCellNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The table cell AST node
 * 
 * @package Document
 * @version //autogen//
 * @access private
 */
class ezcDocumentRstTableCellNode extends ezcDocumentRstNode
{
    /**
     * Table cell colspan
     * 
     * @var int
     */
    public $colspan = 1;

    /**
     * Table cell rowspan
     * 
     * @var int
     */
    public $rowspan = 1;

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
        parent::__construct( $token, self::TABLE_CELL );
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return $this->colspan . ', ' . $this->rowspan;
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
        $node = new ezcDocumentRstTableCellNode(
            $properties['token']
        );

        $node->nodes = $properties['nodes'];

        $node->colspan = $properties['colspan'];
        $node->rowspan = $properties['rowspan'];

        return $node;
    }
}

?>
