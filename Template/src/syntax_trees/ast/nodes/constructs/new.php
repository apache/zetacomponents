<?php
/**
 * File containing the ezcTemplateEchoAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents an echo construct.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateNewAstNode extends ezcTemplateStatementAstNode
{
    /**
     */
    public $class;

    /**
     */
    public function __construct( $class = null )
    {
        parent::__construct();
        $this->class = $class;
    }

    /**
     * Validates the output parameters against their constraints.
     *
     * @throw Exception if the constraints are not met.
     * @todo Fix exception class
     */
    public function validate()
    {
    }
}
?>
