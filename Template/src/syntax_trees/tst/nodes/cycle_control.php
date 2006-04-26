<?php
/**
 * File containing the ezcTemplateCycleControlTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCycleControlTstNode extends ezcTemplateBlockTstNode
{
    public $name;

    public $variables;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end, $name = null )
    {
        parent::__construct( $source, $start, $end );
        $this->name = $name;
        $this->variables = array();

        $this->isNestingBlock = false;
    }

    public function getTreeProperties()
    {
        return array( 'name'       => $this->name,
                      'variables'   => $this->variables );
    }
    
}
?>
