<?php

class ezcDocumentOdtTestStyler extends ezcDocumentOdtStyler
{
    public $styleInfo;

    public $seenElements = array();

    public function init( ezcDocumentOdtStyleInformation $styleInfo )
    {
        $this->styleInfo = $styleInfo;
    }

    public function applyStyles( ezcDocumentLocateable $docBookElement, DOMElement $odtElement )
    {
        $this->seenElements[] = array(
            $docBookElement->tagName,
            $odtElement->tagName
        );
    }
}

?>
