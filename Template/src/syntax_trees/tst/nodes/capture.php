<?php
/**
 * File containing the ezcTemplateCaptureTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCaptureTstNode extends ezcTemplateBlockTstNode
{
    public $variable;

    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end)
    {
        parent::__construct( $source, $start, $end );
        $this->isNestingBlock = true;
    }

    public function getTreeProperties()
    {
        return array( 'variable'  => $this->variable,
                      'children'  => $this->children );
    }
    
}
?>
