<?php
/**
 * File containing the ezcTemplateLoopTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Misc flow control blocks: break/continue/skip/delimiter.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateLoopTstNode extends ezcTemplateBlockTstNode
{
    public $name;

    /**
     * Constructor.
     *
     * @param ezcTemplateSource $source
     * @param ezcTemplateCursor $start
     * @param ezcTemplateCursor $end
     */
    public function __construct( ezcTemplateSourceCode $source, /*ezcTemplateCursor*/ $start, /*ezcTemplateCursor*/ $end, $name = null )
    {
        parent::__construct( $source, $start, $end );
        $this->name = $name;
    }
}
?>
