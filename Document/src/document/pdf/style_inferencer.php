<?php
/**
 * File containing the ezcDocumentPdfStyleInferencer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Style inferencer
 *
 * Inferences the style of a element, basing on the default styles for the
 * element and the given list of user defined style directives.
 *
 * This class is meant to return a list of styles for any element in the
 * Docbook document tree. To speed up the inferencing process styles for
 * elements with the same path are cached.
 *
 * The inferencing algorithm basically works like:
 *
 * 1) Apply the default styles to the element
 * 2) Inherit styles from the parent element
 * 3) Apply styles from all given style directives in their given order, so
 *    that rules defined later overwrite rules defined earlier.
 *
 * @package Document
 * @version //autogen//
 */
class ezcDocumentPdfStyleInferencer
{
    /**
     * Style cache
     *
     * Caches styles for defined paths. This speeds up resolving of styles for
     * similar or same elements multiple times.
     * 
     * @var array
     */
    protected $styleCache = array();

    /**
     * Ordered list of style directives
     *
     * Ordered list of style directvies, which each include the pattern, and a
     * list of formatting rules. Matching directives are applied in the given
     * order and may overwrite each other.
     * 
     * @var array
     */
    protected $styleDirectives = array();

    /**
     * Append list of style directives
     *
     * Append another set of style directives. Since style directives are
     * applied in the given order and may overwrite each other, all given
     * directives might overwrite existing formatting rules.
     * 
     * @param array $styleDirectives 
     * @return void
     */
    public function appendStyleDirectives( array $styleDirectives )
    {
        $this->styleDirectives = array_merge(
            $this->styleDirectives,
            $styleDirectives
        );
    }

    /**
     * Inference formatting rules for element
     *
     * Inference the formatting rules for the passed DOMElement. First the
     * cache will be checked for already inferenced formatting rules defined
     * for this element type, using its generated location identifier.
     *
     * Of not cached, the formatting rules will be inferenced using the
     * algorithm described in the class header.
     * 
     * @param DOMElement $element 
     * @return void
     */
    public function inferenceFormattingRules( ezcDocumentPdfInferencableDomElement $element )
    {
        return array();
    }
}

