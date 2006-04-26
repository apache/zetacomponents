<?php
/**
 * File containing the ezcTemplateEmptyBlockTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Block element containing an empty block.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateEmptyBlockTstNode extends ezcTemplateBlockTstNode
{
    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array();
    }

    /**
     * Returns true since empty block elements can always be children of blocks.
     *
     * @return true
     */
     /*
    public function canBeChildOf( ezcTemplateBlockTstNode $block )
    {
        // Empty block elements can always be child of blocks
        return true;
    }
    */

    /**
     * @inheritdocs
     * Returns the column of the starting cursor.
     */
    public function minimumWhitespaceColumn()
    {
        return $this->startCursor->column;
    }
}
?>
