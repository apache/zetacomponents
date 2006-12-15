<?php
/**
 * File containing the ezcTemplateThrowException class
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
 * @version //autogen//
 * @access private
 */
class ezcTemplateThrowExceptionAstNode extends ezcTemplateStatementAstNode
{
    /**
     * The constant value for the type.
     */
    public $message;

    /**
     * @param mixed $value The value of PHP type to be stored in code element.
     */
    public function __construct( $message )
    {
        parent::__construct();

        $this->message = $message;
    }
}
?>
