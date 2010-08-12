<?php
/**
 * File containing the ezcWebdavNautilusPropertyHandler class.
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
 * @package Webdav
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Property handler adjusted for the GNOME Nautilus client.
 *
 * This property handler removes the "charset=..." part form getcontentype
 * properties, since Nautilus displays them not nicely.
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavNautilusPropertyHandler extends ezcWebdavPropertyHandler
{
    /**
     * Returns the XML representation of a live property.
     *
     * Returns a DOMElement, representing the content of the given $property.
     * The newly created element is also appended as a child to the given
     * $parentElement.
     *
     * This method only takes care for {@link ezcWebdavGetContentTypeProperty}
     * and does not add the "charset=..." part to the generated XML output,
     * since Nautilus does not display this nicely. All other properties are
     * dispatched to the default {@link ezcWebdavPropertyHandler}.
     * 
     * @param ezcWebdavLiveProperty $property 
     * @param DOMElement $parentElement 
     * @return DOMElement
     */
    protected function serializeLiveProperty( ezcWebdavLiveProperty $property, DOMElement $parentElement )
    {
        switch ( get_class( $property ) )
        {
            case 'ezcWebdavGetContentTypeProperty':
                $elementName  = 'getcontenttype';
                $elementValue = ( $property->mime !== null ? $property->mime : null );
                break;
            default:
                return parent::serializeLiveProperty( $property, $parentElement );
        }

        $propertyElement = $parentElement->appendChild( 
            ezcWebdavServer::getInstance()->xmlTool->createDomElement( $parentElement->ownerDocument, $elementName, $property->namespace )
        );

        if ( $elementValue instanceof DOMDocument )
        {
            $propertyElement->appendChild(
                $dom->importNode( $elementValue->documentElement, true )
            );
        }
        else if ( is_array( $elementValue ) )
        {
            foreach ( $elementValue as $subValue )
            {
                $propertyElement->appendChild( $subValue );
            }
        }
        else if ( is_scalar( $elementValue ) )
        {
            $propertyElement->nodeValue = $elementValue;
        }

        return $propertyElement;
    }
}

?>
