<?php
/**
 * File containing the ezcDocumentWikiToken struct
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Struct for Wiki document document tokens
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiToken extends ezcBaseStruct
{
    // Token type constants
    const WHITESPACE      = 1;
    const NEWLINE         = 2;
    const EOF             = 6;

    const BACKSLASH       = 3;
    const SPECIAL_CHARS   = 4;

    const TEXT_LINE       = 5;
    const ESCAPE_CHAR     = 7;

    const BOLD            = 10;
    const ITALIC          = 11;
    const LINE_BREAK      = 12;
    const INLINE_LITERAL  = 13;

    const TITLE           = 20;
    const BULLET_LIST     = 21;
    const ENUMERATED_LIST = 22;
    const PAGE_BREAK      = 23;
    const IMAGE_START     = 24;
    const IMAGE_END       = 25;
    const LITERAL_BLOCK   = 26;

    const LINK_START      = 30;
    const LINK_END        = 31;
    const SEPARATOR       = 32;
    const EXTERNAL_LINK   = 33;
    const INTERNAL_LINK   = 34;
    const INTER_WIKI_LINK = 35;

    /**
     * Token type
     * 
     * @var int
     */
    public $type;

    /**
     * Token content
     * 
     * @var mixed
     */
    public $content;

    /**
     * Line of the token in the source file
     * 
     * @var int
     */
    public $line;

    /**
     * Position of the token in its line.
     * 
     * @var int
     */
    public $position;

    /**
     * Construct Wiki token
     * 
     * @ignore
     * @param int $type 
     * @param mixed $content 
     * @param int $line 
     * @param int $position 
     * @param bool $escaped
     * @return void
     */
    public function __construct( $type, $content, $line, $position = 0 )
    {
        $this->type     = $type;
        $this->content  = $content;
        $this->line     = $line;
        $this->position = $position;
    }

    /**
     * Get token name from type
     *
     * Return a user readable name from the numeric token type.
     * 
     * @param int $type 
     * @return string
     */
    public static function getTokenName( $type )
    {
        $names = array(
            self::WHITESPACE    => 'Whitespace',
            self::NEWLINE       => 'Newline',
            self::BACKSLASH     => 'Backslash',
            self::SPECIAL_CHARS => 'Special character group',
            self::TEXT_LINE     => 'Text',
            self::EOF           => 'End Of File',
        );

        if ( !isset( $names[$type] ) )
        {
            return 'Unknown';
        }

        return $names[$type];
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
        return new ezcDocumentWikiToken(
            $properties['type'],
            $properties['content'],
            $properties['line'],
            $properties['position']
        );
    }
}

?>
