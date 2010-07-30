<?php
/**
 * File containing the ezcSearchRstXmlExtractor class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
     * The document type for this document is given in $type, and the images on
     * disk should be in the directory named $imagePath. The urls where the
     * images link to should be in $imageUrlPath.
     *
     * @param string $fileName
     * @param string $type
     * @param string $url
     * @param string $imagePath
     * @param string $imageUrlPath
     * @return array(ezcSearchDocument)
     */
    static public function extract( $fileName, $type, $url, $imagePath = null, $imageUrlPath = null )
    {
        $published = filemtime( $fileName );

        $converted = file_get_contents( $fileName );
        $dom = new DomDocument();
        @$dom->loadHtml( $converted );
        $tbody = $dom->getElementsByTagName( 'div' )->item( 0 );

        $xpath = new DOMXPath($dom);
        $tocElem = $xpath->evaluate( "//h1[@class='title']", $tbody )->item( 0 );
        $title = $tocElem ? $tocElem->nodeValue : 'no title';

        $docs = array();
        $body = $urls = array();
        $currentUrl = $url;
        $lastUrl = $url;
        $currentBody = '';

        // child::*[self::p or self::h1]
        $xpath = new DOMXPath($dom);
        $tbody = $xpath->evaluate( "//p|//h1|//ol|//ul|//dl|//img|//a", $tbody );
        $body = '';
        foreach( $tbody as $item )
        {
            switch ( $item->tagName )
            {
                case 'a':
                        $name = $item->getAttribute( 'name' );
                        if ( strlen( $name ) )
                        {
                            $currentUrl = $url . '#'. $name;
                        }
                    break;
                case 'img':
                        $alt = $item->getAttribute( 'alt' );
                        $src = $item->getAttribute( 'src' );
                        $location = $imagePath == null ?
                            (dirname( $fileName ). '/'. $src) : 
                            ($imagePath. '/'. preg_replace( '@(\.\./)+@', '', $src ) );
                        $imgurl = $src[0] == '/' ?
                            $src :
                            ($imageUrlPath === null ?
                                ($url . '/' . $src) :
                                ($imageUrlPath. '/'. preg_replace( '@(\.\./)+@', '', $src ) ) );
                        echo "  - $src => $imgurl\n";
                        $docs[] = self::extractImage( $alt, $location, $imgurl );
                    break;
                case 'p':
                case 'h1':
                case 'dl':
                        if ( $lastUrl !== $currentUrl )
                        {
                            $docs[] = new ezcSearchSimpleArticle( null, $title, $currentBody, $published, $lastUrl, $type );
                            $currentBody = '';
                            $lastUrl = $currentUrl;
                        }
                        $currentBody .= strip_tags( $dom->saveXml( $item ) ) . "\n\n";
                    break;
            }
        }
        if ( $currentBody != '' )
        {
            $docs[] = new ezcSearchSimpleArticle( null, $title, $currentBody, $published, $lastUrl, $type );
        }
        return $docs;
    }

    /**
     * Extracts basic information from an image.
     *
     * This method takes an image file and retrives some basic data from it
     * (width and height). It returns an ezcSearchSimpleImage object with those
     * values set.  The image object will get the title $title and the url $url
     * associated with it.
     *
     * @param string $title
     * @param string $filename
     * @param string $url
     *
     * @return ezcSearchSimpleImage
     */
    private static function extractImage( $title, $filename, $url )
    {
        $info = getimagesize( $filename );

        return new ezcSearchSimpleImage( null, $title, $url, $info[0], $info[1], $info['mime'], $url );
    }
}
?>
