<?php
/**
 * File containing the ezcTemplateCloneAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Represents an clone construct.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCloneAstNode extends ezcTemplateStatementAstNode
{
    /**
     */
    public $object;

    /**
     */
    public function __construct( $object = null )
    {
        parent::__construct();
        $this->object = $object;
    }

    /**
     * Validates the output parameters against their constraints.
     *
     * @throws Exception if the constraints are not met.
     * @todo Fix exception class
     */
    public function validate()
    {
    }
}
?>
