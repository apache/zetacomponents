<?php
/**
 * File containing the ezcTemplateLiteralArrayAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 *
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateLiteralArrayAstNode extends ezcTemplateAstNode
{
    /**
     * The constant value for the type.
     */
    public $value = array();
    public $key = array();

    public function checkAndSetTypeHint()
    {
        $this->typeHint = ezcTemplateAstNode::TYPE_ARRAY;
    }

    /**
     * @param mixed $value The value of PHP type to be stored in code element.
     */
    public function __construct( )
    {
        parent::__construct();
        $this->checkAndSetTypeHint();
    }
}
?>
