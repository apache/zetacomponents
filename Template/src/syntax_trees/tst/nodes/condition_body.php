<?php
/**
 * File containing the ezcTemplateIfConditionTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Control structure: if.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateConditionBodyTstNode extends ezcTemplateBlockTstNode
{
    public $condition;

    /*
    // Array.
    public $body;
    */

    /**
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
        $this->condition = null;

        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'condition' => $this->condition,
                      'children'  => $this->children );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        die ("HAndle condition body");
        parent::handleElement( $element );
    }
}
?>
