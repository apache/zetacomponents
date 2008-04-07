<?php
/**
 * File containing the ezcSearchRstXmlExtractor class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class extracts title and body from a parsed RST file in XML format.
 *
 * @package Search
 * @version //autogentag//
 */
class ezcSearchRstXmlExtractor /* implements ezcSearchExtractor */
{
    /**
     * Extracts information from the file $fileName associated with the url $url.
     *
     * @param string $fileName
     * @param string $url
     * @return array(ezcSearchDocument)
     */
    static public function extract( $fileName, $url )
    {
        $published = filemtime( $fileName );

        $converted = file_get_contents( $fileName );
        $dom = new DomDocument();
        @$dom->loadHtml( $converted );
        $tbody = $dom->getElementsByTagName('div')->item(0);

        $xpath = new DOMXPath($dom);
        $tocElem = $xpath->evaluate("//h1[@class='title']", $tbody )->item(0);
        $title = $tocElem->nodeValue;

        $tbody = $dom->getElementsByTagName('p');
        $body = '';
        foreach( $tbody as $item )
        {
            $body .= strip_tags( $dom->saveXml( $item ) ) . "\n\n";
        }

        return array( new ezcSearchSimpleArticle( null, $title, $body, $published, $url ) );
    }
}
?>
