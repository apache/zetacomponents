<?php
/**
 * File containing the ezcDocumentRstDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Visitor for RST directives
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcDocumentRstDirective
{
    /**
     * Current directive RST AST node.
     * 
     * @var ezcDocumentRstDirectiveNode
     */
    protected $node;

    /**
     * Complete RST abstract syntax tree, if this is necessary to render the
     * directive.
     * 
     * @var ezcDocumentRstDocumentNode
     */
    protected $ast;

    /**
     * Current document base path, especially relevant for file inclusions.
     * 
     * @var string
     */
    protected $path;

    /**
     * Construct directive from AST and node
     * 
     * @param ezcDocumentRstDocumentNode $ast 
     * @param string $path
     * @param ezcDocumentRstDirectiveNode $node 
     * @return void
     */
    public function __construct( ezcDocumentRstDocumentNode $ast, $path, ezcDocumentRstDirectiveNode $node )
    {
        $this->ast  = $ast;
        $this->path = $path;
        $this->node = $node;
    }

    /**
     * Transform directive to docbook
     *
     * Create a docbook XML structure at the directives position in the
     * document.
     * 
     * @param DOMDocument $document 
     * @param DOMElement $root 
     * @return void
     */
    abstract public function toDocbook( DOMDocument $document, DOMElement $root );
}

?>
