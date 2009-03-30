<?php
/**
 * File containing the ezcDocumentPdfStyleInferencer class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
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
 * @access private
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

        // Clear styl cache, since new styles may leed to different results
        $this->styleCache = array();
    }

    /**
     * Merge formatting rules
     *
     * Merges two sets of formatting rules, while rules set in the second rule
     * set will always overwrite existing rules of the same name in the first.
     * Rules in the first set, not existing in the second will left untouched.
     * 
     * @param array $base 
     * @param array $new 
     * @return array
     */
    protected function mergeFormattingRules( array $base, array $new )
    {
        foreach ( $new as $k => $v )
        {
            $base[$k] = $v;
        }

        return $base;
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
        // Check style cache early, to speed things up.
        $locationId = $element->getLocationId();
        if ( isset( $this->styleCache[$locationId] ) )
        {
            return $this->styleCache[$locationId];
        }

        // Check if we are at the root node, otherwise inherit style directives
        $formats = array();
        if ( !$element->parentNode instanceof DOMDocument )
        {
            $formats = $this->inferenceFormattingRules( $element->parentNode );
        }

        // Apply all style directives, which match the location ID
        foreach ( $this->styleDirectives as $directive )
        {
            if ( preg_match( $directive->getRegularExpression(), $locationId ) )
            {
                $formats = $this->mergeFormattingRules(
                    $formats,
                    $directive->formats
                );
            }
        }

        return $formats;
    }
}
?>
