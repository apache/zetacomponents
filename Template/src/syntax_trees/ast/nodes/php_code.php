<?php
/**
 * File containing the ezcTemplatePHPCodeAstNode class
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
 */
class ezcTemplatePhpCodeAstNode extends ezcTemplateStatementAstNode
{
    public $code;

    public function __construct( $code = null )
    {
        parent::__construct();
        $this->code = $code;
    }
}
?>
