<?php
/**
 * File containing the ezcTemplateNopAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a PHP code which does nothing.
 * This is typically used to null out existing PHP code.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateNopAstNode extends ezcTemplateStatementAstNode
{
    const TYPE_DYNAMIC_OPEN = 10;
    const TYPE_DYNAMIC_CLOSE = 11;

    public $type = 0; 

    /**
     */
    public function __construct()
    {
        parent::__construct();
    }
}
?>
