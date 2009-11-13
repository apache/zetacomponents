<?php
/**
 * File containing the ezcDocumentOdtPcssTextDecorationConverter class.
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Style converter for text-decoration style properties.
 *
 * @TODO: ODT supports much more fine-graned text-decoration properties than 
 *        PCSS currently supports. Should try to support more ODT features in 
 *        latter versions.
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentOdtPcssTextDecorationConverter implements ezcDocumentOdtPcssConverter
{
    /**
     * Converts the 'text-decoration' CSS style.
     *
     * This method receives a $targetProperty DOMElement and converts the given 
     * style with $styleName and $styleValue to attributes on this 
     * $targetProperty.
     * 
     * @param DOMElement $targetProperty 
     * @param string $styleName 
     * @param ezcDocumentPcssStyleValue $styleValue 
     */
    public function convert( DOMElement $targetProperty, $styleName, ezcDocumentPcssStyleValue $styleValue )
    {
        foreach ( $styleValue->value as $listElement )
        {
            switch ( $listElement )
            {
                case 'line-through':
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-type',
                        'single'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-style',
                        'solid'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-width',
                        'auto'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-line-through-color',
                        'font-color'
                    );
                    break;
                case 'underline':
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-type',
                        'single'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-style',
                        'solid'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-width',
                        'auto'
                    );
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-underline-color',
                        'font-color'
                    );
                    break;
                case 'overline':
                    break;
                case 'blink':
                    $targetProperty->setAttributeNS(
                        ezcDocumentOdt::NS_ODT_STYLE,
                        'style:text-blinking',
                        'true'
                    );
                    break;
            }
        }
    }
}

?>
