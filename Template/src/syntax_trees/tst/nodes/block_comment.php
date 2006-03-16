<?php
/**
 * File containing the ezcTemplateBlockCommentTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Inline block comments in parser trees.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateBlockCommentTstNode extends ezcTemplateExpressionTstNode
{
    /**
     * The parsed comment text without the start and end markers.
     */
    public $commentText;

    /**
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->commentText = null;
    }

    public function getTreeProperties()
    {
        return array( 'commentText' => $this->commentText );
    }

    /**
     *
     * @retval ezcTemplateAstNode
     * @todo Not implemented yet.
     */
    public function transform(  )
    {
    }

}
?>
