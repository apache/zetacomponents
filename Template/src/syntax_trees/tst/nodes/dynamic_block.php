<?php
/**
 * File containing the ezcTemplateDynamicBlockTstNode  class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The dynamic block node contains the possible the dynamic block.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDynamicBlockTstNode extends ezcTemplateBlockTstNode
{
   public $type = 0; 

    //public $isClosingBlock = false;


    /**
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end )
    {
        parent::__construct( $source, $start, $end );
    }

    public function getTreeProperties()
    {
        return array( );
    }
}
?>
