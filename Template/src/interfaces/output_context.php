<?php
/**
 * File containing the ezcTemplateOutputContext class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Controls output handling in the template engine.
 *
 * The template engine will use the various methods in an output context object
 * to control how the end result is.
 *
 * The parser will use the cleanupWhitespace(), cleanupEol() and indent() methods.
 *
 *
 * The compiler will use the transformOutput() method when generating PHP
 * structures for output.
 *
 * @todo This class only works as a stub for now, the actual interface will be
 *       refined when the transformation and parser code is added.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
interface ezcTemplateOutputContext
{

    /**
     *
     */
    public function cleanupWhitespace();

    /**
     *
     */
    public function cleanupEol();

    /**
     *
     */
    public function indent();

    /**
     * Transforms an expressions so it can be displayed in the current output context
     * correctly.
     *
     */
    public function transformOutput();

    /**
     * Returns the unique identifier for the context handler. This is used to
     * uniquely identify the handler, e.g. it is included in the path of
     * compiled files.
     */
    public function identifier();

}
?>
