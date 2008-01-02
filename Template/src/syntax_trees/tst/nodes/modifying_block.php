<?php
/**
 * File containing the ezcTemplateModifyingBlockTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Block element containing an modifying expression.
 *
 * @package Template
 * @version //autogen//
 * @access private
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
     * Note: Temporary compatability with $children
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

    public function getTreeProperties()
    {
        return array( 'startBracket'   => $this->startBracket,
                      'endBracket'     => $this->endBracket,
                      'expressionRoot' => $this->expressionRoot );
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
     * {@inheritdoc}
     * Returns the column of the starting cursor.
     */
    public function minimumWhitespaceColumn()
    {
        return $this->startCursor->column;
    }
}
?>
