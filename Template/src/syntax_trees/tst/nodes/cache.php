<?php
/**
 * File containing the ezcTemplateCacheTstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * The cache node contains the possible caching information.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCacheTstNode extends ezcTemplateExpressionTstNode
{
    const TYPE_NOT_SET = 0;
    const TYPE_TEMPLATE_CACHE = 1;
    const TYPE_DYNAMIC_OPEN = 10;
    const TYPE_DYNAMIC_CLOSE = 11;

    public $type = 0; 

    public $templateCache = false;

    public $isClosingBlock = false;


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
        return array( 'templateCache' => $this->templateCache);
    }
}
?>
