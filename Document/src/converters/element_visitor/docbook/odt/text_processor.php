<?php

class ezcDocumentOdtTextProcessor
{
    /**
     * Checks if whitespaces need additional processing and returns the 
     * corresponding DOMText for the ODT.
     *
     * This method checks if the given $textNode is descendant of a 
     * <literallayout /> tag. In this case, whitespaces are processed according 
     * to the ODT specs:
     *
     * - More than 2 simple spaces are replaced by a single space and <text:s 
     *   /> with the text:c attribute set to the number of spaces - 1.
     * - One or more tabs / line breaks are replaced by a <text:tab/> / 
     *   <text:line-break/> tag, with the text:c attribute set to the number of 
     *   whitespaces replaced.
     * 
     * @param DOMText $textNode 
     * @param DOMElement $newRoot 
     * @return DOMText|DOMFragment
     */
    public function processText( DOMText $textNode, DOMElement $newRoot )
    {
        $parent = $this->getParent( $textNode );

        if ( strpos( $parent->getLocationId(), '/literallayout' ) === false )
        {
            return new DOMText( $textNode->data );
        }
        return $this->processSpaces( $textNode, $newRoot );
    }

    /**
     * Processes whitespaces in $textNode and returns a fragment for the ODT.
     *
     * Processes whitespaces in $textNode according to the rules described at 
     * {@link processText()}. Returns a new DOMDocumentFragment, containing the 
     * processed nodes.
     * 
     * @param DOMText $textNode 
     * @param DOMElement $newRoot 
     * @return DOMDocumentFragment
     */
    protected function processSpaces( DOMText $textNode, DOMElement $newRoot )
    {
        $frag = $newRoot->ownerDocument->createDocumentFragment();

        // Match more than 2 spaces and tabs and line breaks
        preg_match_all(
            '((?: ){2,}|\\t+|\\n+)',
            $textNode->data,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        $startOffset = 0;
        foreach ( $matches[0] as $match )
        {
            $matchType   = $this->getMatchType( $match[0] );
            $matchLength = iconv_strlen( $match[0] );

            // Append text prepending the current match
            $frag->appendChild(
                new DOMText(
                    iconv_substr(
                        $textNode->data,
                        $startOffset,
                        $match[1] - $startOffset
                    )
                    // Append 1 normal space, if spaces matched (ODT specs)
                    . ( $matchType === 's' ? ' ' : '' )
                )
            );

            // Create space element
            $spaceElement = $frag->appendChild(
                $newRoot->ownerDocument->createElementNS(
                    ezcDocumentOdt::NS_ODT_TEXT,
                    $matchType
                )
            );
            
            // Set counter attribute
            $spaceElement->setAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'text:c',
                // For normal spaces, a single one is kept in tact (ODT specs)
                $matchLength - ( $matchType === 's' ? 1 : 0 )
            );

            $startOffset = $match[1] + $matchLength;
        }
        // Append rest of the text after the last match
        if ( $startOffset < iconv_strlen( $textNode->data ) )
        {
            $frag->appendChild(
                new DOMText(
                    iconv_substr( $textNode->data, $startOffset )
                )
            );
        }

        return $frag;
    }

    /**
     * Returns what type of whitespace was matched.
     *
     * Returns a string indicating what type of whitespaces has been matched. 
     * This string is also the name of the text:* tag used to reflect the 
     * whitespace in ODT:
     *
     * - 's' for spaces
     * - 'tab' for tabs
     * - 'line-break' for line breaks
     * 
     * @param string $string 
     * @return string
     */
    protected function getMatchType( $string )
    {
        switch ( iconv_substr( $string, 0, 1 ) )
        {
            case ' ':
                return 's';
            case "\t":
                return 'tab';
            case "\n":
                return 'line-break';
        }
    }

    /**
     * Returns the ancestor DOMElement for $node.
     *
     * Returns the next ancestor DOMElement vor $node.
     * 
     * @param DOMNode $node 
     * @return DOMElement
     */
    protected function getParent( DOMNode $node )
    {
        if ( $node->parentNode->nodeType === XML_ELEMENT_NODE )
        {
            return $node->parentNode;
        }
        return $this->getParent( $node );
    }
}

?>
