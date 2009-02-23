<?php
/**
 * File containing the ezcTemplateThrowException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * This node represents a throw Runtime exception.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateThrowExceptionAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The constant value for the type.
     *
     * @var string
     */
    public $message;

    /**
     * Constructs a new exception.
     *
     * @param string $message The value of PHP type to be stored in code element.
     */
    public function __construct( $message )
    {
        parent::__construct();

        $this->message = $message;
    }
}
?>
