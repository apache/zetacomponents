<?php
/**
 * File containing the ezcDocumentRstEnumeratedListNode struct
 *
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * The enumeration lsit item AST node
 * 
 * @package TextLine
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
class ezcDocumentRstEnumeratedListNode extends ezcDocumentRstNode
{
    /**
     * EnumeratedList indentation level
     * 
     * @var int
     */
    public $indentation;

    /**
     * Enumerated list type, should be one of the following:
     *  - 0: Numeric
     *  - 1: Uppercase
     *  - 2: Lowercase
     *  - 3: Uppercase roman
     *  - 4: Lowercase roman
     * 
     * @var int
     */
    public $type;

    /**
     * Construct RST document node
     * 
     * @param ezcDocumentRstToken $token 
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token )
    {
        // Perhaps check, that only node of type section and metadata are
        // added.
        parent::__construct( $token, self::ENUMERATED_LIST );
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return trim( $this->token->content ) . ', ' . $this->indentation;
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
        $node = new ezcDocumentRstEnumeratedListNode(
            $properties['token']
        );

        $node->type        = $properties['type'];
        $node->nodes       = $properties['nodes'];
        $node->indentation = $properties['indentation'];
        return $node;
    }
}

?>
