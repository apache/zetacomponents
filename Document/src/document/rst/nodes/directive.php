<?php
/**
 * File containing the ezcDocumentRstDirectiveNode struct
 *
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The AST node for RST document directives
 * 
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
class ezcDocumentRstDirectiveNode extends ezcDocumentRstNode
{
    /**
     * Directive target identifier
     * 
     * @var string
     */
    public $identifier;

    /**
     * Directive paramters
     * 
     * @var string
     */
    public $parameters;

    /**
     * Directive options
     * 
     * @var array
     */
    public $options;

    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @param string $identifier
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, $identifier )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::DIRECTIVE );
        $this->identifier = $identifier;
    }

    /**
     * Set state after var_export
     * 
     * @param array $properties 
     * @return void
     * @ignore
     */
    public static function __set_state( $properties )
    {
        $node = new ezcDocumentRstDirectiveNode(
            $properties['token'],
            $properties['identifier']
        );

        $node->nodes      = $properties['nodes'];
        $node->parameters = $properties['parameters'];
        $node->options    = $properties['options'];
        return $node;
    }
}

?>
