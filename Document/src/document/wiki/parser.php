<?php
/**
 * File containing the ezcDocumentWikiParser
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Parser for wiki documents
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentWikiParser extends ezcDocumentParser
{
    /**
     * Array containing simplified shift ruleset
     * 
     * We cannot express the Wiki syntax as a usual grammar using a BNF. With
     * the pumping lemma for context free grammars [1] you can easily prove,
     * that the word a^n b c^n d e^n is not a context free grammar, and this is
     * what the title definitions are.
     *
     * This structure contains an array with callbacks implementing the shift
     * rules for all tokens. There may be multiple rules for one single token. 
     *
     * The callbacks itself create syntax elements and push them to the
     * document stack. After each push the reduction callbacks will be called
     * for the pushed elements.
     *
     * The array should look like:
     * <code>
     *  array(
     *      WHITESPACE => array(
     *          reductionMethod,
     *          ...
     *      ),
     *      ...
     *  )
     * </code>
     *
     * [1] http://en.wikipedia.org/wiki/Pumping_lemma_for_context-free_languages
     *
     * @var array
     */
    protected $shifts = array(
        'ezcDocumentWikiEscapeCharacterToken'
            => 'shiftEscapeToken',
        'ezcDocumentWikiTitleToken'
            => 'shiftTitleToken',
        'ezcDocumentWikiNewLineToken'
            => 'shiftNewLineToken',
        'ezcDocumentWikiToken'
            => 'shiftWithTokenConversion',
    );

    /**
     * Array containing simplified reduce ruleset
     *
     * We cannot express the Wiki syntax as a usual grammar using a BNF. This
     * structure implements a pseudo grammar by assigning a number of callbacks
     * for internal methods implementing reduction rules for a detected syntax
     * element.
     *
     * <code>
     *  array(
     *      ezcDocumentWikiNode::DOCUMENT => 'reduceDocument'
     *      ...
     *  )
     * </code>
     * 
     * @var array
     */
    protected $reductions = array(
//        'ezcDocumentWikiMatchingInlineMarkupNode'
//            => 'reduceMatchingInlineMarkup',
        'ezcDocumentWikiParagraphNode' => array(
            'reduceParagraph',
        ),
        'ezcDocumentWikiDocumentNode' => array(
            'reduceDocument',
        ),
        'ezcDocumentWikiInvisibleBreakNode' => array(
            'reduceLineNode',
        ),
        'ezcDocumentWikiMatchingInlineNode' => array(
            'reduceMatchingInlineMarkup',
        ),
        'ezcDocumentWikiBlockquoteNode' => array(
            'reduceBlockquoteNode',
        ),
        'ezcDocumentWikiLinkEndNode' => array(
            'reduceLinkNodes',
        ),
    );

    /**
     * Contains a list of detected syntax elements.
     *
     * At the end of a successfull parsing process this should only contain one
     * document syntax element. During the process it may contain a list of
     * elements, which are up to reduction.
     *
     * Each element in the stack has to be an object extending from
     * ezcDocumentRstNode, which may again contain any amount such objects.
     * This way an abstract syntax tree is constructed.
     * 
     * @var array
     */
    protected $documentStack = array();

    /**
     * Flag if we are inside a line level node
     * 
     * @var bool
     */
    protected $insideLineToken = false;

    /**
     * Array with token node conversions.
     *
     * Token to node conversions are used for tokens, which do not require any
     * additional checking of the tokens context. This is especially useful,
     * because the wiki tokenizer already implement a lot of this logic.
     * 
     * @var array
     */
    protected $conversionsArray = array(
        'ezcDocumentWikiEndOfFileToken'            => 'ezcDocumentWikiDocumentNode',
        'ezcDocumentWikiTextLineToken'             => 'ezcDocumentWikiTextNode',
        'ezcDocumentWikiWhitespaceToken'           => 'ezcDocumentWikiTextNode',
        'ezcDocumentWikiSpecialCharsToken'         => 'ezcDocumentWikiTextNode',
                                            
        'ezcDocumentWikiTitleToken'                => 'ezcDocumentWikiTitleNode',
        'ezcDocumentWikiParagraphIndentationToken' => 'ezcDocumentWikiBlockquoteNode',
        'ezcDocumentWikiQuoteToken'                => 'ezcDocumentWikiBlockquoteNode',
                                            
        'ezcDocumentWikiBoldToken'                 => 'ezcDocumentWikiBoldNode',
        'ezcDocumentWikiItalicToken'               => 'ezcDocumentWikiItalicNode',
        'ezcDocumentWikiUnderlineToken'            => 'ezcDocumentWikiUnderlineNode',
        'ezcDocumentWikiMonospaceToken'            => 'ezcDocumentWikiMonospaceNode',
        'ezcDocumentWikiSubscriptToken'            => 'ezcDocumentWikiSubscriptNode',
        'ezcDocumentWikiSuperscriptToken'          => 'ezcDocumentWikiSuperscriptNode',
        'ezcDocumentWikiDeletedToken'              => 'ezcDocumentWikiDeletedNode',
        'ezcDocumentWikiStrikeToken'               => 'ezcDocumentWikiDeletedNode',
        'ezcDocumentWikiInlineQuoteToken'          => 'ezcDocumentWikiInlineQuoteNode',
        'ezcDocumentWikiLineBreakToken'            => 'ezcDocumentWikiLineBreakNode',

        'ezcDocumentWikiExternalLinkToken'         => 'ezcDocumentWikiExternalLinkNode',
        'ezcDocumentWikiInterWikiLinkToken'        => 'ezcDocumentWikiInterWikiLinkNode',
        'ezcDocumentWikiInternalLinkToken'         => 'ezcDocumentWikiInternalLinkNode',
        'ezcDocumentWikiSeparatorToken'            => 'ezcDocumentWikiSeparatorNode',
        'ezcDocumentWikiLinkStartToken'            => 'ezcDocumentWikiLinkNode',
        'ezcDocumentWikiLinkEndToken'              => 'ezcDocumentWikiLinkEndNode',
    );

    /**
     * Parse token stream
     *
     * Parse an array of ezcDocumentWikiToken objects into a wiki abstract
     * syntax tree.
     * 
     * @param array &$tokens 
     * @return ezcDocumentWikiDocumentNode
     */
    public function parse( array $tokens )
    {
        /* DEBUG
        echo "\n\nStart parser\n============\n\n";
        // /DEBUG */

        while ( ( $token = array_shift( $tokens ) ) !== null )
        {
            /* DEBUG
            echo "[T] Token: " . get_class( $token ) . " at {$token->line}:{$token->position}.\n";
            // /DEBUG */

            // First shift given token by the defined reduction methods
            $node = false;
            foreach ( $this->shifts as $class => $method )
            {
                if ( $token instanceof $class )
                {
                    /* DEBUG
                    echo " - Handle token with ->$method\n";
                    // /DEBUG */

                    // Try to shift the token with current method
                    if ( ( $node = $this->$method( $token, $tokens ) ) !== false )
                    {
                        break;
                    }
                }
            }

            // If the node is still null there was not matching shift rule.
            if ( $node === false )
            {
                return $this->triggerError( E_PARSE, 
                    "Could not find shift rule for token '" . get_class( $token ) . "'.",
                    $token->line, $token->position
                );
            }

            // Token did not result in any node, it should just be ignored.
            if ( $node === null )
            {
                continue;
            }

            /* DEBUG
            echo "[N] Node: " . get_class( $node ) . " at {$node->token->line}:{$node->token->position}.\n";
            // /DEBUG */

            // Apply reductions to shifted node
            foreach ( $this->reductions as $class => $methods )
            {
                if ( $node instanceof $class )
                {
                    foreach ( $methods as $method )
                    {
                        /* DEBUG
                        echo " - Handle node with ->$method\n";
                        // /DEBUG */

                        if ( ( $node = $this->$method( $node ) ) === null )
                        {
                            // The node has been handled, exit loop.
                            break 2;
                        }
                    }
                }
            }

            // Check if reductions have been applied, but still returned a
            // node, just add to document stack in this case.
            if ( $node !== null )
            {
                /* DEBUG
                echo " => Prepend " . get_class( $node ) . " to document stack.\n";
                // /DEBUG */
                array_unshift( $this->documentStack, $node );
            }
        }

        // Check if we successfully reduced the document stack
        if ( ( count( $this->documentStack ) !== 1 ) ||
             ( !( $document = reset( $this->documentStack ) ) instanceof ezcDocumentWikiDocumentNode ) )
        {
            $node = isset( $document ) ? $document : reset( $this->documentStack );
            $this->triggerError(    
                E_PARSE,
                'Expected end of file, got: ' . get_class( $this->documentStack[1] ) . ".",
                null, null, null
            );
        }

        return $document;
    }

    /**
     * Shift escape token
     *
     * Escape tokens will cause that the following token is ignored in his
     * common meaning. The following token is converted to plain text, while
     * the escape token will be removed.
     * 
     * @param ezcDocumentWikiToken $token 
     * @param array &$tokens 
     * @return mixed
     */
    protected function shiftEscapeToken( ezcDocumentWikiToken $token, array &$tokens )
    {
        return false;
    }

    /**
     * Shift title token
     *
     * Some wiki markup languages use a second title token at the end of the
     * line instead of just a line break. In the case we are already inside a
     * line token, just shift an invisible line break.
     * 
     * @param ezcDocumentWikiToken $token 
     * @param array &$tokens 
     * @return mixed
     */
    protected function shiftTitleToken( ezcDocumentWikiToken $token, array &$tokens )
    {
        if ( $this->insideLineToken )
        {
            // If the title token is already the one in the next line reprepend
            // it to the token list.
            if ( $token->position === 0 )
            {
                array_unshift( $tokens, $token );
            }

            $this->insideLineToken = false;
            return new ezcDocumentWikiInvisibleBreakNode( $token );
        }

        return false;
    }

    /**
     * Shift new line token
     *
     * Paragraphs are always indicated by multiple new line tokens. When
     * detected we just shift a paragraph node, which the will be reduced with
     * prior inline nodes.
     * 
     * @param ezcDocumentWikiToken $token 
     * @param array &$tokens 
     * @return mixed
     */
    protected function shiftNewLineToken( ezcDocumentWikiToken $token, array &$tokens )
    {
        // Wiki markup knows a lot of markup, which is limited to one line. If
        // a token starting su a line the $insideLineToken flag is set true and
        // we shift an end marker to the stack for a single new line.
        if ( $this->insideLineToken )
        {
            /* DEBUG
            echo "  -> End of line markup.\n";
            // /DEBUG */

            $this->insideLineToken = false;
            return new ezcDocumentWikiInvisibleBreakNode( $token );
        }

        // Only shift a paragraph node, if there are multiple new lines, and if
        // there is already inline markup on the document stack.
        if ( isset( $tokens[0] ) &&
             ( $tokens[0] instanceof ezcDocumentWikiNewLineToken ) &&
             isset( $this->documentStack[0] ) &&
             ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) )
        {
            // Remove all subsequent new line tokens.
            do {
                array_shift( $tokens );
            } while ( isset( $tokens[0] ) &&
                      ( $tokens[0] instanceof ezcDocumentWikiNewLineToken ) );

            /* DEBUG
            echo "  -> End of paragraph.\n";
            // /DEBUG */

            return new ezcDocumentWikiParagraphNode( $token );
        }

        // Ignore all other newlines
        return null;
    }

    /**
     * Shift with token conversion
     * 
     * Token to node conversions are used for tokens, which do not require any
     * additional checking of the tokens context. This is especially useful,
     * because the wiki tokenizer already implement a lot of this logic.
     *
     * The actual conversions are specified in the class property
     * $conversionsArray.
     *
     * @param ezcDocumentWikiToken $token 
     * @param array &$tokens 
     * @return mixed
     */
    protected function shiftWithTokenConversion( ezcDocumentWikiToken $token, array &$tokens )
    {
        foreach ( $this->conversionsArray as $tokenClass => $nodeClass )
        {
            if ( $token instanceof $tokenClass )
            {
                if ( $token instanceof ezcDocumentWikiLineMarkupToken )
                {
                    $this->insideLineToken = true;
                }

                /* DEBUG
                echo "  -> Converted  to $nodeClass (" . ( (int) $this->insideLineToken ) . ")\n";
                // /DEBUG */
                return new $nodeClass( $token );
            }
        }

        return false;
    }

    /**
     * Reduce paragraph
     *
     * Paragraphs are reduce with all inline tokens, which have been added to
     * the document stack before. If there are no inline nodes, the paragraph
     * will be ommitted.
     * 
     * @param ezcDocumentWikiParagraphNode $node 
     * @return mixed
     */
    protected function reduceParagraph( ezcDocumentWikiParagraphNode $node )
    {
        // Collect inline nodes
        $collected = array();
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) )
        {
            $inlineNode = array_shift( $this->documentStack );

            // Convert markup nodes without matches to text nodes.
            if ( ( $inlineNode instanceof ezcDocumentWikiMatchingInlineNode ) &&
                 ( $inlineNode->nodes === array() ) )
            {
                $inlineNode = new ezcDocumentWikiTextNode( $inlineNode->token );
            }

            array_unshift( $collected, $inlineNode );
        }

        if ( !count( $collected ) )
        {
            // No tokens found, we can ommit the paragraph.
            return null;
        }

        // Reduce text nodes in single AST nodes
        $textNode = null;
        foreach ( $collected as $nr => $child )
        {
            if ( $child instanceof ezcDocumentWikiTextNode )
            {
                if ( $textNode === null )
                {
                    $textNode = $child;
                }
                else
                {
                    $textNode->token->content .= $child->token->content;
                    unset( $collected[$nr] );
                }
            }
            else
            {
                $textNode = null;
            }
        }

        $node->nodes = array_values( $collected );
        return $node;
    }

    /**
     * Reduce matching inline markup
     *
     * Reduction rule for inline markup which is intended to have a matching
     * counterpart in the same block level element.
     * 
     * @param ezcDocumentWikiMatchingInlineNode $node 
     * @return mixed
     */
    protected function reduceMatchingInlineMarkup( ezcDocumentWikiMatchingInlineNode $node )
    {
        // Collect inline nodes
        $collected = array();
        $class     = get_class( $node );
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) &&
                ( ( !$this->documentStack[0] instanceof $class ) ||
                  ( $this->documentStack[0]->nodes !== array() ) ) )
        {
            array_unshift( $collected, array_shift( $this->documentStack ) );
        }

        if ( isset( $this->documentStack[0] ) &&
             ( $this->documentStack[0] instanceof $class ) &&
             ( $this->documentStack[0]->nodes === array() ) )
        {
            // We found an empty matching node. Reduce
            $markupNode = array_shift( $this->documentStack );
            $markupNode->nodes = $collected;
            return $markupNode;
        }
        else
        {
            // No matching node found, just leave it on the stack.
            $this->documentStack = array_merge( array_reverse( $collected ), $this->documentStack );
            return $node;
        }
    }

    /**
     * Reduce line node
     *
     * Line nodes are closed at the end of their respective line. The end is
     * marked by an ezcDocumentWikiInvisibleBreakNode.
     * 
     * @param ezcDocumentWikiInvisibleBreakNode $node 
     * @return mixed
     */
    protected function reduceLineNode( ezcDocumentWikiInvisibleBreakNode $node )
    {
        // Collect inline nodes
        /* DEBUG
        echo "  -> Find childs for line level markup:";
        // /DEBUG */
        $collected = array();
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) )
        {
            array_unshift( $collected, array_shift( $this->documentStack ) );
            /* DEBUG
            echo ".";
            // /DEBUG */
        }
        /* DEBUG
        echo " " . count( $collected ) . " found.\n";
        // /DEBUG */

        if ( count( $collected ) &&
             isset( $this->documentStack[0] ) &&
             ( $this->documentStack[0] instanceof ezcDocumentWikiLineLevelNode ) )
        {
            $this->documentStack[0]->nodes = $collected;

            /* DEBUG
            echo "  => Reduce line node: " . get_class( $this->documentStack[0] ) . "\n";
            // /DEBUG */
            return null;
        }

        // No tokens found, we can ommit the break node, and put everything
        // back on the document stack
        /* DEBUG
        echo "  => Nothing found - line break ommitted.\n";
        // /DEBUG */
        $this->documentStack = array_merge( array_reverse( $collected ), $this->documentStack );
        return null;
    }

    /**
     * Reduce wiki image links
     *
     * Reduce image links with all of their aggregated parameters.
     * 
     * @param ezcDocumentWikiLinkEndToken $node 
     * @return mixed
     */
    protected function reduceLinkNodes( ezcDocumentWikiLinkEndNode $node )
    {
        // Collect inline nodes
        $collected = array( array() );
        $parameter = 0;
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) &&
                ( !$this->documentStack[0] instanceof ezcDocumentWikiLinkNode ) )
        {
            $child = array_shift( $this->documentStack );
            if ( $child instanceof ezcDocumentWikiSeparatorNode )
            {
                $collected[++$parameter] = array();
            }
            else
            {
                array_unshift( $collected[$parameter], $child );
            }
        }

        // We could not find a corresponding start element, put everything back
        // on stack and convert node into plain text
        if ( !isset( $this->documentStack[0] ) ||
             ( !$this->documentStack[0] instanceof ezcDocumentWikiLinkNode ) )
        {
            $this->documentStack = array_merge( array_reverse( $collected ), $this->documentStack );
            return new ezcDocumentWikiTextNode( $node->token );
        }

        // Reverse parameter order
        $collected = array_reverse( $collected );
        $linkStart = array_shift( $this->documentStack );

        $parameter = $linkStart->token->getLinkParameterOrder( count( $collected ) );
        foreach ( $parameter as $nr => $name )
        {
            $linkStart->$name = $collected[$nr];
        }

        return $linkStart;
    }

    /**
     * Reduce multiline blockquote nodes
     *
     * Reduce multline block quote nodes, which are not already closed by line
     * endings.
     * 
     * @param ezcDocumentWikiBlockquoteNode $node 
     * @return mixed
     */
    protected function reduceBlockquoteNode( ezcDocumentWikiBlockquoteNode $node )
    {
        // Collect inline nodes
        $collected = array();
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiInlineNode ) &&
                ( ( !$this->documentStack[0] instanceof ezcDocumentWikiBlockquoteNode ) ||
                  ( $this->documentStack[0]->nodes !== array() ) ) )
        {
            array_unshift( $collected, array_shift( $this->documentStack ) );
        }

        if ( isset( $this->documentStack[0] ) &&
             ( $this->documentStack[0] instanceof ezcDocumentWikiBlockquoteNode ) &&
             ( $this->documentStack[0]->nodes === array() ) )
        {
            // We found an empty matching node. Reduce
            $blockquote = array_shift( $this->documentStack );
            $blockquote->nodes = $collected;
            return $blockquote;
        }
        else
        {
            // No matching node found, just leave it on the stack.
            $this->documentStack = array_merge( array_reverse( $collected ), $this->documentStack );
            return $node;
        }
    }

    /**
     * Reduce document
     *
     * The document reduction aggregates all block level nodes from the
     * document stack and appends them to the document node. No other nodes are
     * appended, so they will cause a parse error.
     * 
     * @param ezcDocumentWikiDocumentNode $node 
     * @return mixed
     */
    protected function reduceDocument( ezcDocumentWikiDocumentNode $node )
    {
        // Collect inline nodes
        $collected = array();
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentWikiBlockLevelNode ) )
        {
            array_unshift( $collected, array_shift( $this->documentStack ) );
        }

        $node->nodes = $collected;
        return $node;
    }
}

?>
