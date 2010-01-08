<?php
/**
 * File containing the ezcTemplateDynamicStringAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a dynamic PHP string.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateDynamicStringAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     * Initialize dynamic string with parameter constraints.
     */
    public function __construct()
    {
        parent::__construct( 0, false );
    }
}
?>
