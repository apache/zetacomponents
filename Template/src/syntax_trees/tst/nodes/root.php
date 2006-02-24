<?php
/**
 * File containing the ezcTemplateRootTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * The root elements for all parser elements.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateRootTstNode extends ezcTemplateBlockTstNode
{
    /**
     * Array of all elements.
     *
     * @var array
     */
    public $elements;

    /**
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
    }

    public function symbol()
    {
        return '/';
    }

    /**
     * @inheritdocs
     * Returns the column of the starting cursor.
     */
    public function minimumWhitespaceColumn()
    {
        return $this->startCursor->column;
    }

    /**
     * @inheritdocs
     * Trims away ending whitespace for all sub-blocks, the trimming of the
     * first text block is not done since this is a root element and not a
     * standard block element.
     */
    public function trimLine( ezcTemplateWhitespaceRemoval $removal )
    {
        if ( count( $this->children ) == 0 )
            return;

        // Tell the removal object to trim text blocks after the current block
        // and after all sub-blocks.
        $removal->trimBlockLines( $this, $this->children );
    }

    public function accept( ezcTemplateTstNodeVisitor $visitor  )
    {
        $visitor->visitRootTstNode( $this );
    }
}
?>
