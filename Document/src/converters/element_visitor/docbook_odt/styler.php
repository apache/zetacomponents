<?php
/**
 * File containing the ezcDocumentOdtStyler class.
 *
 * @access private
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */


/**
 * Dispatcher and manager for style creation in ODT documents.
 *
 * An instance of this class is used to dispatch and manage style generation in 
 * {@link ezcDocumentDocbookToOdtConverter}.
 *
 * @access private
 * @package Document
 * @version //autogen//
 * @TODO: Create interface and rename.
 */
class ezcDocumentOdtStyler
{
    /**
     * Style converter manager. 
     * 
     * @var ezcDocumentOdtStyleConverterManager
     */
    protected $styleConverters;

    /**
     * Set of style generators to use. 
     * 
     * @var array(ezcDocumentOdtStyleGenerator)
     */
    protected $styleGenerators;

    /**
     * Style inferencer on DocBook source. 
     * 
     * @var ezcDocumentPcssStyleInferencer
     */
    protected $styleInferencer;

    /**
     * Style sections for the current ODT document. 
     * 
     * @var ezcDocumentOdtStyleInformation
     */
    protected $styleInfo;

    /**
     * Creates a new ODT document styler.
     *
     * Creates a new styler. Note that {@link init()} must be 
     * called before {@link applyStyles()} can be used. Otherwise an exception 
     * is thrown.
     * 
     * @param DOMDocument $odtDocument 
     * @param ezcDocumentOdtStyleConverterManager $styleConverters 
     */
    public function __construct()
    {
        // @TODO: Make configurable
        $this->styleInferencer   = new ezcDocumentPcssStyleInferencer();
        $this->styleConverters   = new ezcDocumentOdtStyleConverterManager();
        $this->styleGenerators[] = new ezcDocumentOdtParagraphStyleGenerator(
            $this->styleConverters
        );
    }

    /**
     * Initialize the styler with the given $styleInfo.
     *
     * This method *must* be called *before* {@link applyStyles()} is called 
     * at all. Otherwise an exception will be thrown.
     * 
     * @param ezcDocumentOdtStyleInformation $styleInfo 
     */
    public function init( ezcDocumentOdtStyleInformation $styleInfo )
    {
        $this->styleInfo = $styleInfo;
    }

    /**
     * Applies the given $style to the $odtElement.
     *
     * $style is an array of style information as produced by {@link 
     * ezcDocumentPcssStyleInferencer::inferenceFormattingRules()}. The styling 
     * information given in this array is applied to the $odtElement by 
     * creating a new anonymous style in the ODT style section and applying the 
     * corresponding attributes to reference this style.
     * 
     * @param DOMElement $odtElement 
     * @param array $styles
     * @throws ezcDocumentOdtStylerNotInitializedException
     */
    public function applyStyles( ezcDocumentLocateable $docBookElement, DOMElement $odtElement )
    {
        $styles = $this->styleInferencer->inferenceFormattingRules( $docBookElement );
        foreach ( $this->styleGenerators as $generator )
        {
            if ( $generator->handles( $odtElement ) )
            {
                $generator->createStyle( $this->styleInfo, $odtElement, $styles );
            }
        }
    }
}

?>
