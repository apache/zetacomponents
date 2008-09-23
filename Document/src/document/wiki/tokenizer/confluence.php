<?php
/**
 * File containing the ezcDocumentWikiConfluenceTokenizer
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Tokenizer for Confluence wiki documents.
 *
 * The Confluence wiki is a quite popular wiki and part of the Atlassian
 * software stack. It is chosen, because it uses an entirely different markup
 * in some places, compared to the other wiki markup languages. The markup is
 * documented at:
 *
 * http://confluence.atlassian.com/renderer/notationhelp.action?section=all
 *
 * For the basic workings of the tokenizer see the class level documentation in
 * the ezcDocumentWikiTokenizer class.
 * 
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiConfluenceTokenizer extends ezcDocumentWikiTokenizer
{
    /**
     * Common whitespace characters. The vertical tab is excluded, because it
     * causes strange problems with PCRE.
     */
    const WHITESPACE_CHARS  = '[\\x20\\t]';

    /**
     * Regular sub expression to match newlines.
     */
    const NEW_LINE  = '[\\x20\\t]*(?:\\r\\n|\\r|\\n)';

    /**
     * Characters ending a pure text section.
     */
    const TEXT_END_CHARS    = '/*^,#_~?+!\\\\\\[\\]{}|=\\r\\n\\t\\x20-';

    /**
     * Special characters, which do have some special meaaning and though may
     * not have been matched otherwise.
     */
    const SPECIAL_CHARS     = '/*^,#_~?+!\\\\\\[\\]{}|=-';

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
            array(
                'class' => 'ezcDocumentWikiTitleToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>h[1-6].' . self::WHITESPACE_CHARS . '*))S' ),
            array(
                'class' => 'ezcDocumentWikiParagraphIndentationToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>bq.)' . self::WHITESPACE_CHARS . '*)S' ),
            array(
                'class' => 'ezcDocumentWikiQuoteToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>\\{quote\\}))S' ),
            array(
                'class' => 'ezcDocumentWikiPageBreakToken',
                'match' => '(\\A(?P<match>' . self::NEW_LINE . self::WHITESPACE_CHARS . '*(?P<value>-{4})' . self::WHITESPACE_CHARS . '*)' . self::NEW_LINE . ')S' ),
            array(
                'class' => 'ezcDocumentWikiBulletListItemToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>(?:\\*|-)+)' . self::WHITESPACE_CHARS . '+)S' ),
            array(
                'class' => 'ezcDocumentWikiEnumeratedListItemToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>#+)' . self::WHITESPACE_CHARS . '+)S' ),
            array(
                'class' => 'ezcDocumentWikiTableRowToken',
                'match' => '(\\A(?P<match>' . self::NEW_LINE . ')(?P<value>\\|))S' ),
            array(
                'class' => 'ezcDocumentWikiPluginToken',
                'match' => '(\\A' . self::NEW_LINE . '(?P<value>\\{([a-zA-Z]+)[^}]*\\}(?:.*?' . self::NEW_LINE . '\\{\\2\\})?))Ss' ),

            // Whitespaces
            array(
                'class' => 'ezcDocumentWikiNewLineToken',
                'match' => '(\\A' . self::WHITESPACE_CHARS . '*(?P<value>\\r\\n|\\r|\\n))S' ),
            array(
                'class' => 'ezcDocumentWikiWhitespaceToken',
                'match' => '(\\A(?P<value>' . self::WHITESPACE_CHARS . '+))S' ),
            array(
                'class' => 'ezcDocumentWikiEndOfFileToken',
                'match' => '(\\A(?P<value>\\x0c))S' ),

            // Escape character
            array(
                'class' => 'ezcDocumentWikiEscapeCharacterToken',
                'match' => '(\\A(?P<match>(?P<value>\\\\))[^\\\\])S' ),

            // Inline markup
            array(
                'class' => 'ezcDocumentWikiBoldToken',
                'match' => '(\\A(?P<value>\\*))S' ),
            array(
                'class' => 'ezcDocumentWikiItalicToken',
                'match' => '(\\A(?P<value>_))S' ),
            array(
                'class' => 'ezcDocumentWikiSuperscriptToken',
                'match' => '(\\A(?P<value>\\^))S' ),
            array(
                'class' => 'ezcDocumentWikiSubscriptToken',
                'match' => '(\\A(?P<value>~))S' ),
            array(
                'class' => 'ezcDocumentWikiUnderlineToken',
                'match' => '(\\A(?P<value>\\+))S' ),
            array(
                'class' => 'ezcDocumentWikiStrikeToken',
                'match' => '(\\A(?P<value>-))S' ),
            array(
                'class' => 'ezcDocumentWikiInlineQuoteToken',
                'match' => '(\\A(?P<value>\\?\\?))S' ),
            array(
                'class' => 'ezcDocumentWikiMonospaceToken',
                'match' => '(\\A(?P<value>\\{\\{|\\}\\}))S' ),
            array(
                'class' => 'ezcDocumentWikiLineBreakToken',
                'match' => '(\\A(?P<value>\\\\\\\\))S' ),
            array(
                'class' => 'ezcDocumentWikiLinkStartToken',
                'match' => '(\\A(?P<value>\\[))S' ),
            array(
                'class' => 'ezcDocumentWikiLinkEndToken',
                'match' => '(\\A(?P<value>\\]))S' ),
            array(
                'class' => 'ezcDocumentWikiTableHeaderToken',
                'match' => '(\\A(?P<value>\\|\\|))S' ),
            array(
                'class' => 'ezcDocumentWikiSeparatorToken',
                'match' => '(\\A(?P<value>\\|))S' ),
            array(
                'class' => 'ezcDocumentWikiExternalLinkToken',
                'match' => '(\\A(?P<match>(?P<value>[a-z]+://\\S+?|mailto:\\S+?))[,.?!:;"\']?(?:' . self::WHITESPACE_CHARS . '|' . self::NEW_LINE . '|\\||]|$))S' ),
            array(
                'class' => 'ezcDocumentWikiImageStartToken',
                'match' => '(\\A(?P<match>(?P<value>!))\S)S' ),
            array(
                'class' => 'ezcDocumentWikiImageEndToken',
                'match' => '(\\A(?P<value>!))S' ),

            // Match text except 
            array(
                'class' => 'ezcDocumentWikiTextLineToken',
                'match' => '(\\A(?P<value>[^' . self::TEXT_END_CHARS . ']+))S' ),

            // Match all special characters, which are not valid textual chars,
            // but do not have been matched by any other expression.
            array(
                'class' => 'ezcDocumentWikiSpecialCharsToken',
                'match' => '(\\A(?P<value>(?:[' . self::SPECIAL_CHARS . '])+))S' ),
        );
    }

    /**
     * Parse plugin contents
     *
     * Plugins are totally different in each wiki component and its contents
     * should not be passed through the normal wiki parser. So we fetch its
     * contents completely and let each tokinzer extract names and parameters
     * from the complete token itself.
     * 
     * @param ezcDocumentWikiPluginToken $plugin 
     * @return void
     */
    protected function parsePluginContents( ezcDocumentWikiPluginToken $plugin )
    {
        // Match name of plugin
        if ( preg_match( '(^[a-z]+)i', $plugin->content, $match ) )
        {
            $plugin->type = $match[0];
        }

        // Match plugin parameters
        $parameters = array();
        if ( preg_match_all( '(\s+(?P<key>[a-zA-Z_-]+)=([\'"])(?P<value>.*?)(?!\\\\)\\2)s', $plugin->content, $match ) )
        {
            foreach ( $match['key'] as $nr => $key )
            {
                $parameters[$key] = $match['value'][$nr];
            }
        }
        $plugin->parameters = $parameters;
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
        foreach ( $tokens as $token )
        {
            switch ( true )
            {
                // Extract the title / indentation level from the tokens
                // length.
                case $token instanceof ezcDocumentWikiTitleToken:
                    $token->level = (int) $token->content[1];
                    break;

                case $token instanceof ezcDocumentWikiParagraphIndentationToken:
                    $token->level = 1;
                    break;

                case $token instanceof ezcDocumentWikiBulletListItemToken:
                case $token instanceof ezcDocumentWikiEnumeratedListItemToken:
                    $token->indentation = strlen( $token->content );
                    break;

                case $token instanceof ezcDocumentWikiPluginToken:
                    $this->parsePluginContents( $token );
                    break;
            }
        }

        return $tokens;
    }
}

?>
