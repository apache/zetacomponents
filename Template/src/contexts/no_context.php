<?php

class ezcTemplateNoContext implements ezcTemplateOutputContext
{
    public function cleanupWhitespace() { }

    public function cleanupEol() { }

    public function indent() { }

    public function transformOutput( ezcTemplateAstNode $node )
    {
        return  $node; 
    }

    /**
     * Returns the unique identifier for the context handler.
     */
    public function identifier()
    {
        return 'no_context';
    }
}

?>
