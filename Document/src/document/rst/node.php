<?php
/**
 * File containing the ezcDocumentRstNode struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for RST document document abstract syntax tree nodes
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcDocumentRstNode extends ezcBaseStruct // implements RecursiveIterator
{
    // Node types
    const DOCUMENT             = 1;
    const SECTION              = 1;
    const TITLE                = 2;
    const PARAGRAPH            = 3;
    const TEXT_LINE            = 4;
    const BLOCKQUOTE           = 5;
    const ANNOTATION           = 6;
    const LITERAL_BLOCK        = 7;
    const COMMENT              = 8;
    const TRANSITION           = 9;
    const FIELD_LIST           = 10;
    const DEFINITION_LIST      = 11;
    const LINE_BLOCK           = 12;
    const LINE_BLOCK_LINE      = 13;
    const DEFINITION_LIST_LIST = 14;
                            
    const BULLET_LIST          = 20;
    const ENUMERATED_LIST      = 21;
    const BULLET_LIST_LIST     = 22;
    const ENUMERATED_LIST_LIST = 23;
                            
    const MARKUP_EMPHASIS      = 30;
    const MARKUP_STRONG        = 31;
    const MARKUP_INTERPRETED   = 32;
    const MARKUP_LITERAL       = 33;
    const MARKUP_SUBSTITUTION  = 34;
                            
    const LINK_ANONYMOUS       = 40;
    const LINK_REFERENCE       = 41;
    const TARGET               = 42;
    const REFERENCE            = 43;
                            
    const LITERAL              = 50;
    const SUBSTITUTION         = 51;
    const DIRECTIVE            = 52;
    const NAMED_REFERENCE      = 53;
    const FOOTNOTE             = 54;
    const ANON_REFERENCE       = 55;
                            
    const TABLE                = 100;
    const TABLE_HEAD           = 101;
    const TABLE_BODY           = 102;
    const TABLE_ROW            = 103;
    const TABLE_CELL           = 104;

    /**
     * Line of node in source file.
     * 
     * @var int
     */
    public $line;

    /**
     * Character position of node in source file.
     * 
     * @var int
     */
    public $position;

    /**
     * Node type
     * 
     * @var int
     */
    public $type;

    /**
     * Child nodes
     * 
     * @var mixed
     */
    public $nodes = array();

    /**
     * Optional reference to token, not available for all nodes.
     * 
     * @var ezcDocumentRstToken
     */
    public $token = null;

    /**
     * Optional paragraph identifier, to reference the paragraph using internal
     * links.
     * 
     * @var string
     */
    public $identifier = null;

    /**
     * Construct RST node
     * 
     * @param ezcDocumentRstToken $token
     * @param int $type 
     * @return void
     */
    public function __construct( ezcDocumentRstToken $token, $type )
    {
        $this->type     = $type;
        $this->line     = $token->line;
        $this->position = $token->position;
        $this->token    = $token;
    }

    /**
     * Get node name from type
     *
     * Return a user readable name from the numeric node type.
     * 
     * @param int $type 
     * @return string
     */
    public static function getTokenName( $type )
    {
        $names = array(
            self::DOCUMENT             => 'Document',
            self::SECTION              => 'Section',
            self::TITLE                => 'Title',
            self::PARAGRAPH            => 'Paragraph',
            self::BULLET_LIST          => 'Bullet list item',
            self::ENUMERATED_LIST      => 'Enumerated list item',
            self::BULLET_LIST_LIST     => 'Bullet list',
            self::ENUMERATED_LIST_LIST => 'Enumerated list',
            self::TEXT_LINE            => 'Text line',
            self::BLOCKQUOTE           => 'Blockquote',
            self::ANNOTATION           => 'Blockquote anotation',
            self::COMMENT              => 'Comment',
            self::TRANSITION           => 'Page transition',
            self::FIELD_LIST           => 'Field list',
            self::DEFINITION_LIST      => 'Definition list item',
            self::DEFINITION_LIST_LIST => 'Definition list',
            self::LINE_BLOCK           => 'Line block',
            self::LINE_BLOCK_LINE      => 'Line block line',
            self::LITERAL_BLOCK        => 'Literal block',
            self::MARKUP_EMPHASIS      => 'Emphasis markup',
            self::MARKUP_STRONG        => 'Strong emphasis markup',
            self::MARKUP_INTERPRETED   => 'Interpreted text markup',
            self::MARKUP_LITERAL       => 'Inline literal markup',
            self::MARKUP_SUBSTITUTION  => 'Substitution reference markup',
            self::LINK_ANONYMOUS       => 'Anonymous hyperlink',
            self::LINK_REFERENCE       => 'External Reference',
            self::TARGET               => 'Internal Target',
            self::REFERENCE            => 'Internal Reference',
            self::LITERAL              => 'Inline Literal',
            self::SUBSTITUTION         => 'Substitution target',
            self::DIRECTIVE            => 'Directive',
            self::NAMED_REFERENCE      => 'Named reference target',
            self::FOOTNOTE             => 'Footnote target',
            self::ANON_REFERENCE       => 'Anonymous reference target',
            self::TABLE                => 'Table node',
            self::TABLE_HEAD           => 'Table head node',
            self::TABLE_BODY           => 'Table body node',
            self::TABLE_ROW            => 'Table row node',
            self::TABLE_CELL           => 'Table cell node',
        );

        if ( !isset( $names[$type] ) )
        {
            return 'Unknown';
        }

        return $names[$type];
    }

    /**
     * Return node content, if available somehow
     * 
     * @return string
     */
    protected function content()
    {
        return '';
    }

    /**
     * Get dump of document
     * 
     * @param int $depth 
     * @return string
     */
    public function dump( $depth = 0 )
    {
        $return = sprintf( "%s%s [%s] (%d, %d)\n",
            ( $depth === 0 ? "" : str_repeat( "  ", $depth - 1 ) . "- " ),
            self::getTokenName( $this->type ),
            $this->content(),
            ( isset( $this->token ) ? $this->token->line : 0 ),
            ( isset( $this->token ) ? $this->token->position : 0 )
        );

        foreach ( $this->nodes as $nr => $node )
        {
            if ( !$node instanceof ezcDocumentRstNode )
            {
                $return .= "\n=> Broken child node: $nr.\n";
                continue;
            }

            $return .= $node->dump( $depth + 1 );
        }

        $return .= sprintf( "%s/ %s\n",
            ( $depth === 0 ? "" : str_repeat( "  ", $depth - 1 ) . "- " ),
            self::getTokenName( $this->type )
        );

        return $return;
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
        return new ezcDocumentRstNode(
            $properties['type'],
            $properties['nodes']
        );
    }
}

?>
