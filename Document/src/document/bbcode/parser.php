<?php
/**
 * File containing the ezcDocumentBBCodeParser class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Parser for bbcode documents.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentBBCodeParser extends ezcDocumentParser
{
    /**
     * Array containing simplified shift ruleset.
     *
     * We cannot express the BBCode syntax as a usual grammar using a BNF. With
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
     * [1] http://en.bbcodepedia.org/bbcode/Pumping_lemma_for_context-free_languages
     *
     * @var array
     */
    protected $shifts = array(
        'ezcDocumentBBCodeTagOpenToken'
            => 'shiftOpeningToken',
        'ezcDocumentBBCodeTagCloseToken'
            => 'shiftClosingToken',
        'ezcDocumentBBCodeTextLineToken'
            => 'shiftTextToken',
        'ezcDocumentBBCodeLiteralBlockToken'
            => 'shiftLiteralBlockToken',
        'ezcDocumentBBCodeNewLineToken'
            => 'shiftNewLineToken',
        'ezcDocumentBBCodeEndOfFileToken'
            => 'shiftEndOfFileToken',
    );

    /**
     * Array containing simplified reduce ruleset.
     *
     * We cannot express the BBCode syntax as a usual grammar using a BNF. This
     * structure implements a pseudo grammar by assigning a number of callbacks
     * for internal methods implementing reduction rules for a detected syntax
     * element.
     *
     * <code>
     *  array(
     *      ezcDocumentBBCodeNode::DOCUMENT => 'reduceDocument'
     *      ...
     *  )
     * </code>
     *
     * @var array
     */
    protected $reductions = array(
        'ezcDocumentBBCodeClosingTagNode' => array(
            'reduceTags',
        ),
        'ezcDocumentBBCodeParagraphNode' => array(
            'reduceParagraph',
        ),
        'ezcDocumentBBCodeDocumentNode' => array(
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
     * Parse token stream.
     *
     * Parse an array of ezcDocumentBBCodeToken objects into a bbcode abstract
     * syntax tree.
     *
     * @param array $tokens
     * @return ezcDocumentBBCodeDocumentNode
     */
    public function parse( array $tokens )
    {
        /* DEBUG
        echo "\n\nStart parser\n============\n\n";
        // /DEBUG */

        while ( ( $token = array_shift( $tokens ) ) !== null )
        {
            /* DEBUG
            echo "[T] ({$token->line}:{$token->position}) Token: " . get_class( $token ) . " at {$token->line}:{$token->position}.\n";
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
            do {
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
                                /* DEBUG
                                echo "   - Reduced.\n";
                                // /DEBUG */
                                // The node has been handled, exit loop.
                                break 3;
                            }

                            // Check if the node class has changed and rehandle
                            // node in this case.
                            if ( !$node instanceof $class )
                            {
                                /* DEBUG
                                echo "   - Try subsequent reductions...\n";
                                // /DEBUG */

                                continue 2;
                            }
                        }
                    }
                }
            } while ( false );

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
             ( !( $document = reset( $this->documentStack ) ) instanceof ezcDocumentBBCodeDocumentNode ) )
        {
            $node = isset( $document ) ? $document : reset( $this->documentStack );
            $this->triggerError(
                E_PARSE,
                'Expected end of file, got: ' . get_class( $this->documentStack[1] ) . ".",
                $this->documentStack[1]->token->line, $this->documentStack[1]->token->position
            );
        }

        return $document;
    }

    /**
     * Shift tag opening token
     *
     * Opening tags mean that the following contents will be aggregated, once a 
     * matching closing tag is found. Is just shifted to the document stack.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftOpeningToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        /* DEBUG
        echo " - Shift opening token {$token->content}.\n";
        // /DEBUG */
        return new ezcDocumentBBCodeTagNode( $token );
    }

    /**
     * Shift tag clsoing token
     *
     * Closing tags mean that the preceeding contents will be aggregated, once a 
     * matching opening tag is found. Is just shifted to the document stack, 
     * and the appropriate reduce call will follow right away.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftClosingToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        /* DEBUG
        echo " - Shift closing token {$token->content}.\n";
        // /DEBUG */
        return new ezcDocumentBBCodeClosingTagNode( $token );
    }

    /**
     * Shift title token.
     *
     * Some bbcode markup languages use a second title token at the end of the
     * line instead of just a line break. In the case we are already inside a
     * line token, just shift an invisible line break.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftTextToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        /* DEBUG
        echo " - Shift text node.\n";
        // /DEBUG */
        return new ezcDocumentBBCodeTextNode( $token );
    }

    /**
     * Shift literal block token
     *
     * Literal blocks are just a chunk of code or similar, where the token can 
     * jsut be converted into an apropriate node.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftLiteralBlockToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        // @TODO Differentiate between inline literal and literal block.
        /* DEBUG
        echo " - Shift literal block node.\n";
        // /DEBUG */
        return new ezcDocumentBBCodeLiteralBlockNode( $token );
    }

    /**
     * Shift new line token.
     *
     * Double new lines are considered as paragraphs. All other new lines are 
     * just shifted as single whitespace text nodes.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftNewLineToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        while ( isset( $tokens[0] ) &&
                ( $tokens[0] instanceof ezcDocumentBBCodeWhitespaceToken ) )
        {
            array_shift( $tokens );
        }

        if ( isset( $tokens[0] ) &&
             ( $tokens[0] instanceof ezcDocumentBBCodeNewlineToken ) )
        {
            do {
                array_shift( $tokens );
            } while ( isset( $tokens[0] ) &&
                      ( ( $tokens[0] instanceof ezcDocumentBBCodeNewlineToken ) ||
                        ( $tokens[0] instanceof ezcDocumentBBCodeWhitespaceToken ) ) );
            /* DEBUG
            echo " - Shift paragraph node.\n";
            // /DEBUG */
            return new ezcDocumentBBCodeParagraphNode( $token );
        }
        else
        {
            /* DEBUG
            echo " - Shift newline as whitespace node.\n";
            // /DEBUG */
            return new ezcDocumentBBCodeTextNode( $token );
        }
    }

    /**
     * Shift EOF token.
     *
     * Shift End-Of-File token. We reached the end of the document, and 
     * therefore shift a document node onto the stack.
     *
     * @param ezcDocumentBBCodeToken $token
     * @param array $tokens
     * @return mixed
     */
    protected function shiftEndOfFileToken( ezcDocumentBBCodeToken $token, array &$tokens )
    {
        /* DEBUG
        echo " - Shift document node.\n";
        // /DEBUG */
        return new ezcDocumentBBCodeDocumentNode( $token );
    }

    /**
     * Reduce tags.
     *
     * Locates the matching opening tag for a closing tag and reduces the 
     * contents found on the way back.
     *
     * @param ezcDocumentBBCodeClosingTagNode $node
     * @return mixed
     */
    protected function reduceTags( ezcDocumentBBCodeClosingTagNode $node )
    {
        $nodes = array();
        while ( isset( $this->documentStack[0] ) &&
                ( ( !$this->documentStack[0] instanceof ezcDocumentBBCodeTagNode ) ||
                  ( $this->documentStack[0]->token->content !== $node->token->content ) ) )
        {
            $nodes[] = $child = array_shift( $this->documentStack );

            if ( ( $child instanceof ezcDocumentBBCodeTagNode ) &&
                 ( !count( $child->nodes ) ) )
            {
                return $this->triggerError( E_PARSE,
                    "Opening tag, without matching closing tag found: '" . $child->token->content . "'.",
                    $child->token->line, $child->token->position
                );
            }

            if ( $child instanceof ezcDocumentBBCodeClosingTagNode )
            {
                return $this->triggerError( E_PARSE,
                    "Closing tag, without matching opening tag found: '" . $child->token->content . "'.",
                    $child->token->line, $child->token->position
                );
            }
        }

        if ( ( !$this->documentStack[0] instanceof ezcDocumentBBCodeTagNode ) ||
             ( $this->documentStack[0]->token->content !== $node->token->content ) )
        {
            return $this->triggerError( E_PARSE,
                "Closing tag, without matching opening tag found: '" . $node->token->content . "'.",
                $node->token->line, $node->token->position
            );
        }

        $node = array_shift( $this->documentStack );
        $node->nodes = array_reverse( $nodes );
        return $node;
    }

    /**
     * Reduce paragraph.
     *
     * Paragraphs are reduce with all inline tokens, which have been added to
     * the document stack before. If there are no inline nodes, the paragraph
     * will be ommitted.
     *
     * @param ezcDocumentBBCodeParagraphNode $node
     * @return mixed
     */
    protected function reduceParagraph( ezcDocumentBBCodeParagraphNode $node )
    {
        $nodes = array();
        while ( isset( $this->documentStack[0] ) &&
                ( !$this->documentStack[0] instanceof ezcDocumentBBCodeParagraphNode ) )
        {
            $nodes[] = $child = array_shift( $this->documentStack );

            if ( ( $child instanceof ezcDocumentBBCodeTagNode ) &&
                 ( !count( $child->nodes ) ) )
            {
                return $this->triggerError( E_PARSE,
                    "Opening tag, without matching closing tag found: '" . $child->token->content . "'.",
                    $child->token->line, $child->token->position
                );
            }

            if ( $child instanceof ezcDocumentBBCodeClosingTagNode )
            {
                return $this->triggerError( E_PARSE,
                    "Closing tag, without matching opening tag found: '" . $child->token->content . "'.",
                    $child->token->line, $child->token->position
                );
            }
        }

        // Omit empty paragraphs
        if ( !count( $nodes ) )
        {
            return null;
        }

        $node->nodes = array_reverse( $nodes );
        return $node;
    }

    /**
     * Reduce prior sections, if a new section has been found.
     *
     * If a new section has been found all sections with a higher depth level
     * can be closed, and all items fitting into sections may be aggregated by
     * the respective sections as well.
     *
     * @param ezcDocumentBBCodeDocumentNode $node
     */
    protected function reduceDocument( ezcDocumentBBCodeDocumentNode $node )
    {
        $nodes = array();
        while ( isset( $this->documentStack[0] ) &&
                ( $this->documentStack[0] instanceof ezcDocumentBBCodeParagraphNode ) )
        {
            $nodes[] = array_shift( $this->documentStack );
        }
        $node->nodes = array_reverse( $nodes );

        return $node;
    }
}

?>
