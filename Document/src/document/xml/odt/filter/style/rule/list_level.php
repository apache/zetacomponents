<?php

class ezcDocumentOdtListLevelStyleFilterRule implements ezcDocumentOdtStyleFilterRule
{
    /**
     * Returns if the given $odtElement is handled by the rule.
     * 
     * @param DOMElement $odtElement 
     * @return bool
     */
    public function handles( DOMElement $odtElement )
    {
        return ( $odtElement->localName === 'list' );
    }

    /**
     * Filter the given $odtElement based on the given $style.
     *
     * This method will only be called when handles returned true for the given 
     * $odtElement. The method may manipulate the $odtElement, especially its 
     * attributes, based on the style information.
     * 
     * @param DOMElement $odtElement 
     * @param ezcDocumentOdtStyle $style 
     */
    public function filter( DOMElement $odtElement, ezcDocumentOdtStyleInferencer $styleInferencer )
    {
        $listStyle = $styleInferencer->getListStyle( $odtElement );
        
        $currentLevel = $this->getListLevel( $odtElement );
        
        switch ( get_class( $listStyle->listLevels[$currentLevel] ) )
        {
            case 'ezcDocumentOdtListLevelStyleNumber':
                $this->setNumberListProperties( $odtElement, $listStyle->listLevels[$currentLevel] );
                break;
            case 'ezcDocumentOdtListLevelStyleBullet':
                $this->setItemListProperties( $odtElement, $listStyle->listLevels[$currentLevel] );
                break;
        }
    }

    /**
     * Sets properties of numbered lists based on $listLevelProps.
     * 
     * @param DOMElement $numList 
     * @param ezcDocumentOdtListLevelStyleNumber $listLevelProps 
     * @return void
     */
    protected function setNumberListProperties( DOMElement $numList, ezcDocumentOdtListLevelStyleNumber $listLevelProps )
    {
        $numList->setProperty(
            'type',
            'orderedlist'
        );
    }

    /**
     * Sets properties of itemized lists based on $listLevelProps.
     * 
     * @param DOMElement $numList 
     * @param ezcDocumentOdtListLevelStyleBullet $listLevelProps 
     * @return void
     */
    protected function setItemListProperties( DOMElement $itemList, ezcDocumentOdtListLevelStyleBullet $listLevelProps )
    {
        $itemList->setProperty(
            'type',
            'itemizedlist'
        );
    }

    /**
     * Determines the list level of $odtElement.
     *
     * Note that leveling starts with 1!
     * 
     * @param DOMElement $odtElement 
     * @return int
     */
    protected function getListLevel( DOMElement $odtElement )
    {
        if ( $odtElement->parentNode->nodeType === XML_DOCUMENT_NODE )
        {
            return 1;
        }
        return $this->getListLevel( $odtElement->parentNode )
            + ( $odtElement->parentNode->localName === 'list' ? 1 : 0 );
    }
}

?>
