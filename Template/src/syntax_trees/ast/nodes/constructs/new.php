<?php
/**
 * File containing the ezcTemplateEchoAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a new construct.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 * @access private
 */
class ezcTemplateNewAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     */
    public $class;

    /**
     */
    public function __construct( $class = null, array $functionArguments = null )
    {
        parent::__construct();
        $this->class = $class;

        if ( $functionArguments !== null )
        {
            foreach ( $functionArguments as $argument )
            {
                $this->appendParameter( $argument );
            }
        }
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
