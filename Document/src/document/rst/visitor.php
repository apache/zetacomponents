<?php
/**
 * File containing the ezcDocumentRstVisitor class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Abstract visitor base for RST documents represented by the parser AST.
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcDocumentRstVisitor
{
    /**
     * RST document handler
     * 
     * @var ezcDocumentRst
     */
    protected $rst;

    /**
     * Reference to the AST root node. 
     * 
     * @var ezcDocumentRstDocumentNode
     */
    protected $ast;

    /**
     * Location of the currently processed RST file, relevant for inclusion.
     * 
     * @var string
     */
    protected $path;

    /**
     * Collected refrence targets.
     * 
     * @var array
     */
    protected $references = array();

    /**
     * Collected named external reference targets
     * 
     * @var array
     */
    protected $namedExternalReferences = array();
    
    /**
     * Collected anonymous externals reference targets
     * 
     * @var array
     */
    protected $anonymousReferences = array();

    /**
     * Index of last requested anonymous reference target.
     * 
     * @var int
     */
    protected $anonymousReferenceCounter = 0;

    /**
     * Collected substitutions.
     * 
     * @var array
     */
    protected $substitutions = array();

    /**
     * List with footnotes for later rendering.
     * 
     * @var array
     */
    protected $footnotes = array();

    /**
     * Label dependant foot note counters for footnote auto enumeration.
     * 
     * @var array
     */
    protected $footnoteCounter = array( 0 );

    /**
     * Unused reference target
     */
    const UNUSED    = 1;

    /**
     * Used reference target
     */
    const USED      = 2;

    /**
     * Dublicate reference target. Will throw an error on use.
     */
    const DUBLICATE = 4;

    /**
     * Create visitor from RST document handler.
     * 
     * @param ezcDocumentRst $document 
     * @param string $path
     * @return void
     */
    public function __construct( ezcDocumentRst $document, $path )
    {
        $this->rst  = $document;
        $this->path = $path;
    }

    /**
     * Trigger visitor error
     *
     * Emit a vistitor error, and convert it to an exception depending on the
     * error reporting settings.
     * 
     * @param int $level 
     * @param string $message 
     * @param string $file 
     * @param int $line 
     * @param int $position 
     * @return void
     */
    protected function triggerError( $level, $message, $file, $line = null, $position = null )
    {
        if ( $level & $this->rst->options->errorReporting )
        {
            throw new ezcDocumentVisitException( $level, $message, $file, $line, $position );
        }
    }

    /**
     * Docarate RST AST
     *
     * Visit the RST abstract syntax tree.
     * 
     * @param ezcDocumentRstDocumentNode $ast 
     * @return mixed
     */
    public function visit( ezcDocumentRstDocumentNode $ast )
    {
        $this->ast = $ast;
        $this->preProcessAst( $ast );

        // Reset footnote counters
        foreach ( $this->footnoteCounter as $label => $counter )
        {
            $this->footnoteCounter[$label] = 0;
        }
    }

    /**
     * Add a reference target
     * 
     * @param string $string 
     * @return void
     */
    private function addReferenceTarget( $string )
    {
        $id = $this->calculateId( $string );
        $this->references[$id] = isset( $this->references[$id] ) ? self::DUBLICATE : self::UNUSED;
    }

    /**
     * Transform a node tree into a string
     * 
     * Transform a node tree, with all its subnodes into a string by only
     * getting the textuual contents from ezcDocumentRstTextLineNode objects.
     *
     * @param ezcDocumentRstNode $node 
     * @return string
     */
    protected function nodeToString( ezcDocumentRstNode $node )
    {
        $text = '';

        foreach ( $node->nodes as $child )
        {
            if ( ( $child instanceof ezcDocumentRstTextLineNode ) ||
                 ( $child instanceof ezcDocumentRstLiteralNode ) )
            {
                $text .= $child->token->content;
            }
            else
            {
                $text .= $this->nodeToString( $child );
            }
        }

        return $text;
    }

    /**
     * Get string from token list.
     * 
     * @param array $tokens 
     * @return string
     */
    protected function tokenListToString( array $tokens )
    {
        $text = '';

        foreach ( $tokens as $token )
        {
            $text .= $token->content;
        }

        return $text;
    }

    /**
     * Compare two list items
     *
     * Check if the given list item may be a successor in the same list, as the
     * last item in the list. Returns the boolean status o the check.
     * 
     * @param ezcDocumentRstNode $item 
     * @param ezcDocumentRstToken $lastItem 
     * @return bool
     */
    protected function compareListType( ezcDocumentRstNode $item, ezcDocumentRstToken $lastItem )
    {
        // Those always belong to each other... .oO( ♡ )
        if ( $item instanceof ezcDocumentRstDefinitionListNode )
        {
            return true;
        }

        // For bullet lists, just compare the tokens
        if ( $item instanceof ezcDocumentRstBulletListNode )
        {
            return ( $item->token->content === $lastItem->content );
        }

        // For enumerated lists, we need to check if the current value is a
        // valid successor of the prior value.
        // @TODO: Implement.
        return true;
    }

    /**
     * Aggregate list items
     * 
     * Aggregate list items into lists. In RST there are only list items, which
     * are aggregated to lists depending on their bullet type. The related list
     * items are aggregated into one list.
     * 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function aggregateListItems( ezcDocumentRstNode $node )
    {
        $listTypeMapping = array(
            'ezcDocumentRstBulletListNode'     => 'ezcDocumentRstBulletListListNode',
            'ezcDocumentRstEnumeratedListNode' => 'ezcDocumentRstEnumeratedListListNode',
            'ezcDocumentRstDefinitionListNode' => 'ezcDocumentRstDefinitionListListNode',
        );

        $lastItem = null;
        $list     = null;
        $children = array();
        foreach ( $node->nodes as $nr => $child )
        {
            if ( isset( $listTypeMapping[$class = get_class( $child )] ) )
            {
                if ( ( $lastItem === null ) ||
                     ( $list === null ) ||
                     ( !$this->compareListType( $child, $lastItem ) ) )
                {
                    // Create a new list.
                    $listType = $listTypeMapping[$class];
                    $list = new $listType( $child->token );
                    $list->nodes[] = $child;
                    $children[] = $list;
                }
                else
                {
                    // Append to current list
                    $list->nodes[] = $child;
                }
                $lastItem = $child->token;
            }
            else
            {
                $children[] = $child;
                $lastItem = null;
            }
        }

        $node->nodes = $children;
    }

    /**
     * Add footnote
     * 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function addFootnote( ezcDocumentRstNode $node )
    {
        $identifier = $this->tokenListToString( $node->name );

        if ( is_numeric( $identifier ) )
        {
            $number = (int) $identifier;
            if ( $identifier > $this->footnoteCounter[0] )
            {
                $this->footnoteCounter[$label = 0] = $number;
            }
        }
        elseif ( $identifier[0] === '#' )
        {
            $label = ( strlen( $identifier ) > 1 ? substr( $identifier, 1 ) : 0 );
            
            if ( !isset( $this->footnoteCounter[$label] ) )
            {
                $this->footnoteCounter[$label] = $number = 1;
            }
            else
            {
                $number = ++$this->footnoteCounter[$label];
            }
        }
        else
        {
            return $this->triggerError(
                E_WARNING, "Unknown footnote type '$identifier'.",
                null, $node->token->line, $node->token->position
            );
        }

        // Store footnote for later rendering in footnote array
        $node->name   = $label;
        $node->number = $number;
        $this->footnotes[$label][$number] = $node;
    }

    /**
     * Pre process AST
     *
     * Performs multiple preprocessing steps on the AST:
     *
     * Collect all possible reference targets in the AST to know the actual
     * destianation for references while decorating. The references are stored
     * in an internal structure and you may request the actual link by using
     * the getReferenceTarget() method.
     *
     * Aggregate list items into lists. In RST there are only list items, which
     * are aggregated to lists depending on their bullet type. The related list
     * items are aggregated into one list.
     * 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function preProcessAst( ezcDocumentRstNode $node )
    {
        switch ( true )
        {
            case $node instanceof ezcDocumentRstSectionNode:
                $this->addReferenceTarget( $node->title );
                $this->aggregateListItems( $node );
                break;

            case $node instanceof ezcDocumentRstTableCellNode:
            case $node instanceof ezcDocumentRstBulletListNode:
            case $node instanceof ezcDocumentRstEnumeratedListNode:
                $this->aggregateListItems( $node );
                break;

            case $node instanceof ezcDocumentRstExternalReferenceNode:
                $this->addReferenceTarget( $this->nodeToString( $node ) );
                break;

            case $node instanceof ezcDocumentRstTargetNode:
                $this->addReferenceTarget( $this->nodeToString( $node ) );
                break;

            case $node instanceof ezcDocumentRstNamedReferenceNode:
                if ( count( $node->nodes ) )
                {
                    // This is a direct reference to an external URL, just add
                    // to the list of named external references.
                    $this->namedExternalReferences[$this->tokenListToString( $node->name )] = 
                        trim( $this->nodeToString( $node ) );
                }
                break;

            case $node instanceof ezcDocumentRstAnonymousReferenceNode:
                $this->anonymousReferences[] = trim( $this->nodeToString( $node ) );
                break;

            case $node instanceof ezcDocumentRstSubstitutionNode:
                $substitutionName = strtolower( $this->tokenListToString( $node->name ) );
                $this->substitutions[$substitutionName] = $node->nodes;
                break;

            case $node instanceof ezcDocumentRstFootnoteNode:
                $this->addFootnote( $node );
                break;
        }

        // Check for forward references of empty named references.
        $children = $node->nodes;
        reset( $children );
        while ( $child = next( $children ) )
        {
            $stack = array();
            while ( ( $child instanceof ezcDocumentRstNamedReferenceNode ) &&
                    ( count( $child->nodes ) === 0 ) )
            {
                $stack[] = $child;
                $child = next( $children );
            }

            if ( count( $stack ) )
            {
                // We found a element, which is not an empty named reference
                // node, so get the identifier from it and assign it to all
                // named references on the stack.
                if ( $child instanceof ezcDocumentRstNamedReferenceNode )
                {
                    // Child is a named reference with content, so use the
                    // content as assignement.
                    $reference = trim( $this->nodeToString( $child ) );
                }
                else
                {
                    // Generate a reference name and assign it to the element.
                    $last = end( $stack );
                    $reference = $this->calculateId( $this->tokenListToString( $last->name ) );
                    $child->identifier = $reference;
                }

                // Assign calculated reference to all aggregated stack
                // elements.
                foreach ( $stack as $refNode )
                {
                    $this->namedExternalReferences[$this->tokenListToString( $refNode->name )] = $reference;
                }
            }
        }

        // Recurse into childs to collect reference targets all over the
        // document.
        foreach ( $node->nodes as $child )
        {
            $this->preProcessAst( $child );
        }
    }

    /**
     * Check for internal reference target
     *
     * Returns the target name, when an internal reference target exists and
     * sets it to used, and false otherwise. For dublicate reference targets
     * and missing reference targets an error will be triggered.
     *
     * @param string $string
     * @return string
     */
    protected function hasReferenceTarget( $string )
    {
        // Check if the target name is a footnote reference
        if ( is_numeric( $string ) )
        {
            // We found a labelless footnote
            if ( isset( $this->footnotes[0][$number = (int) $string] ) )
            {
                $this->footnoteCounter[0] = $number;
                return $this->footnotes[0][$number];
            }

            return $this->triggerError(
                E_WARNING, "Unknown reference target '$string'.", null
            );
        }
        elseif ( $string[0] === '#' )
        {
            // We found a (labeled) autonumbered footnote.
            $label = ( strlen( $string ) > 1 ? substr( $string, 1 ) : 0 );
            $number = ++$this->footnoteCounter[$label];

            if ( isset( $this->footnotes[$label][$number] ) )
            {
                return $this->footnotes[$label][$number];
            }

            return $this->triggerError(
                E_WARNING, "Unknown reference target '$string'.", null
            );
        }

        $id = $this->calculateId( $string );
        if ( isset( $this->references[$id] ) &&
             ( $this->references[$id] !== self::DUBLICATE ) )
        {
            $this->references[$id] = self::USED;
            return $id;
        }

        if ( !isset( $this->references[$id] ) )
        {
            return $this->triggerError(
                E_WARNING, "Missing reference target '$id'.", null
            );
        }
        else
        {
            return $this->triggerError(
                E_NOTICE, "Dublicate reference target '$id'.", null
            );
        }
    }

    /**
     * Return named external reference target
     *
     * Get the target value of a named external reference.
     * 
     * @param string $name 
     * @return string
     */
    protected function getNamedExternalReference( $name )
    {
        if ( isset( $this->namedExternalReferences[$name] ) ) 
        {
            return $this->namedExternalReferences[$name];
        }

        return $this->triggerError(
            E_WARNING, "Missing named external reference target '$name'.", null
        );
    }

    /**
     * Get anonymous reference target
     *
     * Get the target URL of an anonomyous reference target.
     * 
     * @return string
     */
    protected function getAnonymousReferenceTarget()
    {
        if ( isset( $this->anonymousReferences[$this->anonymousReferenceCounter] ) )
        {
            return $this->anonymousReferences[$this->anonymousReferenceCounter++];
        }

        return $this->triggerError(
            E_WARNING, "Too few anonymous reference targets.", null
        );
    }

    /**
     * Get substitution contents
     * 
     * @param string $string 
     * @return void
     */
    protected function substitute( $string )
    {
        $string = strtolower( $string );
        if ( isset( $this->substitutions[$string] ) )
        {
            return $this->substitutions[$string];
        }

        $this->triggerError(
            E_ERROR, "Could not find substitution for '$string'.", null
        );
        return array();
    }

    /**
     * Get a valid identifier string
     *
     * Get a valid identifier string from an arbritrary string.
     * 
     * @param string $string 
     * @return string
     */
    protected function calculateId( $string )
    {
        return preg_replace( '([^a-z0-9-]+)', '_', strtolower( $string ) );
    }

    /**
     * Visit text node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitText( DOMNode $root, ezcDocumentRstNode $node )
    {
        $root->appendChild(
            new DOMText( $node->token->content )
        );
    }

    /**
     * Visit children
     *
     * Just recurse into node and visit its children, ignoring the actual
     * node.
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitChildren( DOMNode $root, ezcDocumentRstNode $node )
    {
        foreach ( $node->nodes as $child )
        {
            $this->visitNode( $root, $child );
        }
    }

    /**
     * Visit substitution reference node
     * 
     * @param DOMNode $root 
     * @param ezcDocumentRstNode $node 
     * @return void
     */
    protected function visitSubstitutionReference( DOMNode $root, ezcDocumentRstNode $node )
    {
        if ( ( $substitution = $this->substitute( $this->nodeToString( $node ) ) ) !== null )
        {
            foreach( $substitution as $child )
            {
                $this->visitNode( $root, $child );
            }
        }
    }
}

?>
