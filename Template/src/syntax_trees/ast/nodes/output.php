<?php
/**
 * File containing the ezcTemplateOutputAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateOutputAstNode extends ezcTemplateAstNode
{
    public $expression;

    public $isRaw;

    public function __construct( ezcTemplateAstNode $expression = null )
    {
        parent::__construct();
        $this->expression = $expression;
    }
}
?>
