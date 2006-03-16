<?php
/**
 * File containing the ezcTemplateTypeCastAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateTypeCastAstNode extends ezcTemplateAstNode
{
    /**
     * The constant type.
     */
    public $type;

    public $value;

    /**
     */
    public function __construct( $castToType, $value )
    {
        parent::__construct();

        // TODO, check for int, string, array, etc.

        $this->type  = $castToType;
        $this->value = $value;
    }
}
?>
