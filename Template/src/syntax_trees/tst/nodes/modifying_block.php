<?php
/**
 * File containing the ezcTemplateModifyingBlockTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Block element containing an modifying expression.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateModifyingBlockTstNode extends ezcTemplateBlockTstNode
{
    /**
     * The bracket start character.
     * @var string
     */
    public $startBracket;

    /**
     * The bracket end character.
     * @var string
     */
    public $endBracket;

    /**
     * Array of all child elements.
     * @note Temporary compatability with $children
     *
     * @var array
     */
    public $elements;

    /**
     * The node starting the modifying expression.
     *
     * @var ezcTemplateExpressionTstNode
     */
//    public $element; // removed, not needed

    /**
     * The root of the parsed modifying expression.
     */
    public $expressionRoot;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
//        $this->element = null; // removed, not needed
        $this->startBracket = '{';
        $this->endBracket = '}';
        $this->expressionRoot = null;

        $this->isNestingBlock = false;
    }

    /**
     * Returns true since modifying expression block elements can always be children of blocks.
     *
     * @return true
     */
     /*
    public function canBeChildOf( ezcTemplateBlockTstNode $block )
    {
        // Modifying expression block elements can always be child of blocks
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
