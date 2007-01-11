<?php
/**
 * File containing the ezcTemplateFunctionCallAstNode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Represents a function call.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateFunctionCallAstNode extends ezcTemplateParameterizedAstNode
{
    /**
     * The name of the function to call.
     * @var string
     */
    public $name;

    public function checkAndSetTypeHint()
    {
        $this->typeHint = self::TYPE_ARRAY | self::TYPE_VALUE; 
    }

    /**
     * Initialize with function name code and optional arguments
     */
    public function __construct( $name, Array $functionArguments = null )
    {
        parent::__construct( 1, false );
        $this->name = $name;
        $this->typeHint = self::TYPE_ARRAY | self::TYPE_VALUE;

        if ( $functionArguments !== null )
        {
            foreach ( $functionArguments as $argument )
            {
                $this->appendParameter( $argument );
            }
        }
    }
}
?>
