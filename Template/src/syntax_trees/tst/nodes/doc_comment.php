<?php
/**
 * File containing the ezcTemplateDocCommentTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Doc comment element in parse trees.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDocCommentTstNode extends ezcTemplateBlockTstNode
{
    /**
     * The parsed comment text without the start and end markers.
     */
    public $commentText;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->commentText = null;
        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'name'        => $this->name,
                      'commentText' => $this->commentText );
    }

    /**
     * Returns true since doc comment elements can always be children of blocks.
     *
     * @return true
     */
     /*
    public function canBeChildOf( ezcTemplateBlockTstNode $block )
    {
        // Doc comment elements can always be child of blocks
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
