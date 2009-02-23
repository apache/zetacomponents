<?php
/**
 * File containing the ezcDocumentWikiMediawikiTokenizer
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tokenizer for Mediawiki wiki documents.
 *
 * Mediawiki is probably the most popular wiki, and the driving force behing
 * Wikipedia. The markup has a lot extension, but the basics are defined at:
 *
 * http://www.mediawiki.org/wiki/Markup_spec
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiMediawikiTokenizer extends ezcDocumentWikiTokenizer
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
    const TEXT_END_CHARS    = '/*^,\'_<>\\\\\\[\\]{}()|=\\r\\n\\t\\x20';

    /**
     * Special characters, which do have some special meaaning and though may
     * not have been matched otherwise.
     */
    const SPECIAL_CHARS     = '/*^,\'_<>\\\\\\[\\]{}()|=';

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
        /*
            // Match tokens which require to be at the start of a line before
            // matching the actual newlines, because they are the indicator for
            // line starts.
            'ezcDocumentWikiTitleToken' =>
                '(\\A(?P<match>(?:' . self::NEW_LINE . '|' . self::WHITESPACE_CHARS . '+)(?P<value>={2,6}))(?:' . self::NEW_LINE . '|' . self::WHITESPACE_CHARS . '+))S',
            'ezcDocumentWikiBulletListItemToken' =>
                '(\\A' . self::NEW_LINE . '(?P<value>\\x20*\\*)' . self::WHITESPACE_CHARS . '+)S',
            'ezcDocumentWikiEnumeratedListItemToken' =>
                '(\\A' . self::NEW_LINE . '(?P<value>\\x20*-)' . self::WHITESPACE_CHARS . '+)S',
            'ezcDocumentWikiLiteralBlockToken' =>
                '(\\A(?P<match>' . self::NEW_LINE . '<(code|nowiki|file|html|php)(?:' . self::WHITESPACE_CHARS . '+[a-z]+)?>' . self::NEW_LINE . '(?P<value>.+)' . self::NEW_LINE . '</\\2>)' . self::NEW_LINE . ')SUsi',
            'ezcDocumentWikiTableRowToken' =>
                '(\\A(?P<match>' . self::NEW_LINE . ')(?P<value>[|^]))S',
            'ezcDocumentWikiParagraphIndentationToken' =>
                '(\\A' . self::NEW_LINE . '(?P<value>>+)' . self::WHITESPACE_CHARS . '*)S',

            // Whitespaces
            'ezcDocumentWikiNewLineToken' =>
                '(\\A' . self::WHITESPACE_CHARS . '*(?P<value>\\r\\n|\\r|\\n))S',
            'ezcDocumentWikiWhitespaceToken' =>
                '(\\A(?P<value>' . self::WHITESPACE_CHARS . '+))S',
            'ezcDocumentWikiEndOfFileToken' =>
                '(\\A(?P<value>\\x0c))S',

            // Escape character
            'ezcDocumentWikiEscapeCharacterToken' =>
                '(\\A(?P<value>~))S',

            // Inline markup
            'ezcDocumentWikiBoldToken' =>
                '(\\A(?P<value>\\*\\*))S',
            'ezcDocumentWikiItalicToken' =>
                '(\\A(?P<value>//))S',
            'ezcDocumentWikiMonospaceToken' =>
                '(\\A(?P<value>\'\'))S',
            'ezcDocumentWikiSuperscriptToken' =>
                '(\\A(?P<value></?sup>))Si',
            'ezcDocumentWikiSubscriptToken' =>
                '(\\A(?P<value></?sub>))Si',
            'ezcDocumentWikiUnderlineToken' =>
                '(\\A(?P<value>__))S',
            'ezcDocumentWikiDeletedToken' =>
                '(\\A(?P<value></?del>))Si',
            'ezcDocumentWikiInlineLiteralToken' =>
                '(\\A<nowiki>(?P<value>.*)</nowiki>)SUi',
            'EzcDocumentWikiInlineLiteralToken' =>
                '(\\A%%(?P<value>.*)%%)SUi',
            'ezcDocumentWikiLineBreakToken' =>
                '(\\A(?P<match>(?P<value>\\\\\\\\))(?:' . self::WHITESPACE_CHARS . '|' . self::NEW_LINE . '))S',
            'ezcDocumentWikiLinkStartToken' =>
                '(\\A(?P<value>\\[\\[))S',
            'ezcDocumentWikiLinkEndToken' =>
                '(\\A(?P<value>\\]\\]))S',
            'ezcDocumentWikiSeparatorToken' =>
                '(\\A(?P<value>\\||' . self::WHITESPACE_CHARS . '*->' . self::WHITESPACE_CHARS . '*))S',
            'ezcDocumentWikiExternalLinkToken' =>
                '(\\A
                    (?P<match>
                        (?P<value>
                            # Match common URLs
                            [a-z]+://\S+? | 
                            # Match mail addresses enclosed by <>
                            <[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?>
                        )
                     # Greedy match on text end chars, which should NOT be included in URLs
                     )[,.?!:;"\']?(?:' . self::WHITESPACE_CHARS . '|' . self::NEW_LINE . '|\\||]]|\\}\\}|$)
                )Sx',
            'ezcDocumentWikiInterWikiLinkToken' =>
                '(\\A(?P<value>([A-Za-z]+)>[^\\]|]+))S',
            'ezcDocumentWikiImageStartToken' =>
                '(\\A(?P<value>\\{\\{))S',
            'ezcDocumentWikiImageEndToken' =>
                '(\\A(?P<value>\\}\\}))S',
            'ezcDocumentWikiFootnoteStartToken' =>
                '(\\A(?P<value>\\(\\())S',
            'ezcDocumentWikiFootnoteEndToken' =>
                '(\\A(?P<value>\\)\\)))S',
            'ezcDocumentWikiTableHeaderToken' =>
                '(\\A(?P<value>\\^))S',

            // Match text except 
            'ezcDocumentWikiTextLineToken' =>
                '(\\A(?P<value>[^' . self::TEXT_END_CHARS . ']+))S',

            // Match all special characters, which are not valid textual chars,
            // but do not have been matched by any other expression.
            'ezcDocumentWikiSpecialCharsToken' =>
                '(\\A(?P<value>(?:[' . self::SPECIAL_CHARS . '])+))S',
        // */
        );
    }

    /**
     * Filter tokens
     *
     * Method to filter tokens, after the input string ahs been tokenized. The
     * filter should extract additional information from tokens, which are not
     * generally available yet, like the depth of a title depending on the
     * title markup.
     * 
     * @param array $tokens 
     * @return array
     */
    protected function filterTokens( array $tokens )
    {
        foreach ( $tokens as $nr => $token )
        {
            switch ( true )
            {
                // Extract the title / indentation level from the tokens
                // length.
                case $token instanceof ezcDocumentWikiTitleToken:
                case $token instanceof ezcDocumentWikiParagraphIndentationToken:
                    $token->level = strlen( trim( $token->content ) );
                    break;
            }
        }

        return $tokens;
    }
}

?>
