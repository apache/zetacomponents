<?php
/**
 * File containing the ezcDocumentWikiCreoleTokenizer
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tokenizer for Creole wiki documents.
 *
 * The Creole wiki syntax is a started effort to unify wiki markup languages.
 * Its documentation can be found at:
 *
 * http://www.wikicreole.org/
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiCreoleTokenizer extends ezcDocumentWikiTokenizer
{
    /**
     * Common whitespace characters. The vertical tab is excluded, because it
     * causes strange problems with PCRE.
     */
    const WHITESPACE_CHARS  = '[\\x20\\t]';

    /**
     * Regular sub expression to match newlines.
     */
    const NEW_LINE  = '(?:\\r\\n|\\r|\\n)';

    /**
     * Characters ending a pure text section.
     */
    const TEXT_END_CHARS    = '/*#_\\\\\\[\\]{}|=\\r\\n\\t\\x20-';

    /**
     * Special characters, which do have some special meaaning and though may
     * not have been matched otherwise.
     */
    const SPECIAL_CHARS    = '/*#_\\\\\\[\\]{}|=-';

    /**
     * Construct tokenizer
     *
     * Create token array with regular repression matching the respective
     * token.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->tokens = array(
            // Match tokens which require to be at the start of a line before
            // matching the actual newlines, because they are the indicator for
            // line starts.
            ezcDocumentWikiToken::TITLE =>
                '(\\A' . self::NEW_LINE . '(?P<value>=+)' . self::WHITESPACE_CHARS . '+)S',
            ezcDocumentWikiToken::BULLET_LIST =>
                '(\\A' . self::NEW_LINE . '(?P<value>\\*+)' . self::WHITESPACE_CHARS . '+)S',
            ezcDocumentWikiToken::ENUMERATED_LIST =>
                '(\\A' . self::NEW_LINE . '(?P<value>#+)' . self::WHITESPACE_CHARS . '+)S',
            ezcDocumentWikiToken::PAGE_BREAK =>
                '(\\A(?P<match>' . self::NEW_LINE . self::WHITESPACE_CHARS . '*(?P<value>-{4})' . self::WHITESPACE_CHARS . '*)' . self::NEW_LINE . ')S',
            ezcDocumentWikiToken::LITERAL_BLOCK =>
                '(\\A(?P<match>' . self::NEW_LINE . '\\{\\{\\{' . self::NEW_LINE . '(?P<value>.+)' . self::NEW_LINE . '\\}\\}\\})' . self::NEW_LINE . ')SUs',

            // Whitespaces
            ezcDocumentWikiToken::NEWLINE =>
                '(\\A' . self::WHITESPACE_CHARS . '*(?P<value>\\r\\n|\\r|\\n))S',
            ezcDocumentWikiToken::WHITESPACE =>
                '(\\A(?P<value>' . self::WHITESPACE_CHARS . '+))S',
            ezcDocumentWikiToken::EOF =>
                '(\\A(?P<value>\\x0c))S',

            // Escape character
            ezcDocumentWikiToken::ESCAPE_CHAR =>
                '(\\A(?P<value>~))S',

            // Inline markup
            ezcDocumentWikiToken::BOLD =>
                '(\\A(?P<value>\\*\\*))S',
            ezcDocumentWikiToken::ITALIC =>
                '(\\A(?P<value>//))S',
            ezcDocumentWikiToken::INLINE_LITERAL =>
                '(\\A\\{\\{\\{(?P<value>.+?\\}*)\\}\\}\\})Ss',
            ezcDocumentWikiToken::LINE_BREAK =>
                '(\\A(?P<value>\\\\\\\\))S',
            ezcDocumentWikiToken::IMAGE_START =>
                '(\\A(?P<value>\\{\\{))S',
            ezcDocumentWikiToken::IMAGE_END =>
                '(\\A(?P<value>\\}\\}))S',
            ezcDocumentWikiToken::LINK_START =>
                '(\\A(?P<value>\\[\\[))S',
            ezcDocumentWikiToken::LINK_END =>
                '(\\A(?P<value>\\]\\]))S',
            ezcDocumentWikiToken::SEPARATOR =>
                '(\\A(?P<value>\\||' . self::WHITESPACE_CHARS . '*->' . self::WHITESPACE_CHARS . '*))S',
            ezcDocumentWikiToken::INTER_WIKI_LINK =>
                '(\\A(?P<value>([A-Za-z]+):(?:[A-Z][a-z0-9_-]+){2,}))S',
            ezcDocumentWikiToken::INTERNAL_LINK =>
                '(\\A(?P<value>(?:[A-Z][a-z]+){2,}))S',
            ezcDocumentWikiToken::EXTERNAL_LINK =>
                '(\\A(?P<match>(?P<value>[a-z]+://\S+?))[,.?!:;"\']?(?:' . self::WHITESPACE_CHARS . '|' . self::NEW_LINE . '|\\||]]|\\||$))S',


            // Match text except 
            ezcDocumentWikiToken::TEXT_LINE =>
                '(\\A(?P<value>[^' . self::TEXT_END_CHARS . ']+))S',

            // Match all special characters, which are not valid textual chars,
            // but do not have been matched by any other expression.
            ezcDocumentWikiToken::SPECIAL_CHARS =>
                '(\\A(?P<value>(?:[' . self::SPECIAL_CHARS . '])+))S',
        );
    }
}

?>
