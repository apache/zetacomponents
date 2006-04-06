<?php
/**
 * File containing the ezcTemplateCaseConditionTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Control structure: case.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCaseTstNode extends ezcTemplateBlockTstNode
{
    public $conditions;

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
        $this->conditions = array();

        $this->isNestingBlock = true;
    }

    public function getTreeProperties()
    {
        return array( 'conditions' => $this->conditions,
                      'children'  => $this->children );
    }

    public function handleElement( ezcTemplateTstNode $element )
    {
        parent::handleElement( $element);
    }
}
?>
