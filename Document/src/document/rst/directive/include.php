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
 * Visitor for RST include directives
 * 
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcDocumentRstIncludeDirective extends ezcDocumentRstDirective
{
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
    public function toDocbook( DOMDocument $document, DOMElement $root )
    {
        $file = trim( $this->node->parameters );
        if ( !ezcBaseFile::isAbsolutePath( $file ) )
        {
            // If path to file is not an absolute path, use the given relative
            // path relative to the currently processed document location.
            $file = $this->path . $file;
        }

        // @TODO: docutils performs automatic checks, that no system files
        // (like /etc/passwd) are included - do we want to do similar stuff
        // here?

        // Throw an exception, if we cannot find the referenced file
        if ( !is_file( $file ) || !is_readable( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file );
        }

        if ( isset( $this->node->options['literal'] ) )
        {
            // If the file should be included as a literal, just pass it
            // through in such a block.
            $literal = $document->createElement( 'literallayout', htmlspecialchars( file_get_contents( $file ) ) );
            $root->appendChild( $literal );
        }
        else
        {
            // Otherwise we reenter the complete parsing process with the new file.
            $doc = new ezcDocumentRst();
            $doc->loadFile( $file );

            // Get docbook DOM tree from the parsed file
            $docbook = $doc->getAsDocbook();
            $tree = $docbook->getDomDocument();

            // Import and add the complete parsed document.
            $article = $tree->firstChild;
            foreach ( $article->childNodes as $child )
            {
                $imported = $document->importNode( $child, true );
                $root->appendChild( $imported );
            }
        }
    }
}

?>
