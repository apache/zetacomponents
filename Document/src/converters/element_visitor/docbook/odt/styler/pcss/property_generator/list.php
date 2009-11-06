<?php
/**
 * File containing the ezcDocumentOdtStyleListPropertyGenerator class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * List property generator.
 *
 * Creates and fills the paragraph-properties element.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtStyleListPropertyGenerator extends ezcDocumentOdtStylePropertyGenerator
{
    /**
     * Creates a new paragraph-properties generator.
     * 
     * @param ezcDocumentOdtPcssConverterManager $styleConverters 
     */
    public function __construct( ezcDocumentOdtPcssConverterManager $styleConverters )
    {
        parent::__construct(
            $styleConverters,
            array(
                'margin',
                'text-indent',
            )
        );
    }

    /**
     * Creates the paragraph-properties element.
     *
     * Creates the paragraph-properties element in $parent and applies the fitting $styles.
     * 
     * @param DOMElement $parent 
     * @param array $styles 
     * @return DOMElement The created property
     */
    public function createProperty( DOMElement $parent, array $styles )
    {
        $prop = $parent->appendChild(
            $parent->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'list-level-properties'
            )
        );
        $prop->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:list-level-position-and-space-mode',
            'label-alignment'
        );

        $this->createLabelAllignement( $prop, $styles );
    }

    /**
     * Creates the <style:list-level-label-alignment/> element in $prop. 
     * 
     * @param DOMElement $prop 
     * @param array $styles 
     * @return void
     */
    protected function createLabelAllignement( DOMElement $prop, array $styles )
    {
        $alignementProp = $prop->appendChild(
            $prop->ownerDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'list-level-label-alignment'
            )
        );

        // @TODO: Not found in specs, but in OOO generated docs.
        $alignementProp->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:label-followed-by',
            'listtab'
        );
        // Guessed as good as we can by margin
        $alignementProp->setAttributeNS(
            ezcDocumentOdt::NS_ODT_TEXT,
            'text:list-tab-stop-position',
            sprintf( '%smm', $styles['margin']->value['left'] )
        );
        // Hard coded for now, since we cannot determine it properly here
        $alignementProp->setAttributeNS(
            ezcDocumentOdt::NS_ODT_FO,
            'fo:text-indent',
            sprintf( '%smm', -10 )
        );
        $alignementProp->setAttributeNS(
            ezcDocumentOdt::NS_ODT_FO,
            'fo:margin-left',
            sprintf( '%smm', $styles['margin']->value['left'] )
        );
    }
}

?>
