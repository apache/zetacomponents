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
        'ezcDocumentWikiNewLineToken'
            => 'shiftParagraph',
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
     * Array with token node conversions.
     *
     * Token to node conversions are used for tokens, which do not require any
     * additional checking of the tokens context. This is especially useful,
     * because the wiki tokenizer already implement a lot of this logic.
     * 
     * @var array
     */
    protected $conversionsArray = array(
        'ezcDocumentWikiEndOfFileToken' => 'ezcDocumentWikiDocumentNode',
    );

    /**
     * Parse token stream
     *
     * Parse an array of ezcDocumentWikiToken objects into a wiki abstract
     * syntax tree.
     * 
     * @param array $tokens 
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
                'Expected end of file, got: ' . get_class( $node ) . ".",
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
     * @param array $tokens 
     * @return mixed
     */
    protected function shiftEscapeToken( ezcDocumentWikiToken $token, array $tokens )
    {
        return false;
    }

    /**
     * Shift paragraph
     *
     * Paragraphs are always indicated by multiple new line tokens. When
     * detected we just shift a paragraph node, which the will be reduced with
     * prior inline nodes.
     * 
     * @param ezcDocumentWikiToken $token 
     * @param array $tokens 
     * @return mixed
     */
    protected function shiftParagraph( ezcDocumentWikiToken $token, array $tokens )
    {
        if ( isset( $tokens[0] ) &&
             ( $tokens[0] instanceof ezcDocumentWikiNewLineToken ) )
        {
            // Remove all subsequent new line tokens.
            do {
                array_shift( $tokens );
            } while ( isset( $tokens[0] ) &&
                      ( $tokens[0] instanceof ezcDocumentWikiNewLineToken ) );

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
     * @param array $tokens 
     * @return mixed
     */
    protected function shiftWithTokenConversion( ezcDocumentWikiToken $token, array $tokens )
    {
        foreach ( $this->conversionsArray as $tokenClass => $nodeClass )
        {
            if ( $token instanceof $tokenClass )
            {
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
            array_unshift( $collected, array_shift( $this->documentStack ) );
        }

        if ( !count( $collected ) )
        {
            // No tokens found, we can ommit the paragraph.
            return null;
        }

        $node->nodes = $collected;
        return $node;
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
