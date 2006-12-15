<?php
/**
 * File containing the ezcTemplateXhtmlContext class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcTemplateXhtmlContext class escapes special HTML characters in the
 * output.
 *
 * @package Template
 * @version //autogen//
 */

class ezcTemplateXhtmlContext implements ezcTemplateOutputContext
{
    /**
     * Escapes special HTML characters in the output.
     */
    public function transformOutput( ezcTemplateAstNode $node )
    {
        return new ezcTemplateFunctionCallAstNode( "htmlspecialchars", array( $node ) );
    }

    /**
     * Returns the unique identifier for the context handler.
     */
    public function identifier()
    {
        return 'xhtml';
    }
}
?>
