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
     * Special classes for style directive values
     *
     * If no class is given it will fall back to a generic string value.
     * 
     * @var array
     */
    protected $valueParserClasses = array(
        'font-size'            => 'ezcDocumentPdfStyleMeasureValue', 
        'line-height'          => 'ezcDocumentPdfStyleMeasureValue', 
        'margin'               => 'ezcDocumentPdfStyleMeasureBoxValue', 
        'padding'              => 'ezcDocumentPdfStyleMeasureBoxValue', 
        'text-columns'         => 'ezcDocumentPdfStyleIntValue', 
        'text-columns-spacing' => 'ezcDocumentPdfStyleMeasureValue', 
    );

    /**
     * Construct style inference with default styles
     * 
     * @param bool $loadDefault
     * @return void
     */
    public function __construct( $loadDefault = true )
    {
        if ( $loadDefault )
        {
            $this->loadDefaultStyles();
        }
    }

    /**
     * Set the default styles
     *
     * Creates a list of default styles for very common elements.
     * 
     * @return void
     */
    protected function loadDefaultStyles()
    {
        if ( file_exists( $file = dirname( __FILE__ ) . '/style/default.php' ) )
        {
            $this->appendStyleDirectives( include $file );
        }
        
        // If the file does not exist parse the PCSS style file
        $parser     = new ezcDocumentPdfCssParser();
        $directives = $parser->parseFile( dirname( __FILE__ ) . '/style/default.css' );

        // Write parsed object tree back to file
        /* file_put_contents( $file, "<?php\n\nreturn " . var_export( $directives, true ) . ";\n\n?>" ); // */

        $this->appendStyleDirectives( $directives );
    }

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
        // Convert values, depending on assigned value handler classes
        foreach ( $styleDirectives as $nr => $directive )
        {
            foreach ( $directive->formats as $name => $value )
            {
                $valueHandler = isset( $this->valueParserClasses[$name] ) ? $this->valueParserClasses[$name] : 'ezcDocumentPdfStyleStringValue';
                $styleDirectives[$nr]->formats[$name] = new $valueHandler( $value );
            }
        }

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
     * Inference the formatting rules for the passed DOMElement or location id.
     * First the cache will be checked for already inferenced formatting rules
     * defined for this element type, using its generated location identifier.
     *
     * Of not cached, the formatting rules will be inferenced using the
     * algorithm described in the class header.
     * 
     * @param ezcDocumentPdfLocateable $element 
     * @return array
     */
    public function inferenceFormattingRules( ezcDocumentPdfLocateable $element )
    {
        // Check style cache early, to speed things up.
        $locationId = $element->getLocationId();
        if ( isset( $this->styleCache[$locationId] ) )
        {
            return $this->styleCache[$locationId];
        }

        // Check if we are at the root node, otherwise inherit style directives
        $formats = array();
        if ( ( $element instanceof DOMElement ) &&
             !$element->parentNode instanceof DOMDocument )
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
