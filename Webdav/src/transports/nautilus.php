<?php
/**
 * File containing the ezcWebdavNautilusCompatibleTransport class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Transport layer for Nautilus (GNOME).
 *
 * In newer Nautilus (aka gvfs) versions, WebDAV with authentication does not 
 * accept Multi-Status responses that include absolute URIs. Since using 
 * relative URIs in this cases does not disturb Nautilus in general, this 
 * transport simply converts all URIs in Multi-Status responses to be relative 
 * to the server root.
 *
 * @version //autogentag//
 * @package Webdav
 * @access private
 */
class ezcWebdavNautilusCompatibleTransport extends ezcWebdavTransport
{
    /**
     * Post-processes <href/> XML elements to contain relative URIs.
     *
     * This is needed by Nautilus when auth is enabled.
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return ezcWebdavXmlDisplayInformation
     */
    protected function processPropFindResponse( ezcWebdavPropFindResponse $response )
    {
        $xmlDispInfo = parent::processPropFindResponse( $response );
        $subResponses = $xmlDispInfo->body->getElementsByTagNameNS(
            ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE,
            'response'
        );
        foreach ( $subResponses as $subResponse )
        {
            $hrefs = $subResponse->getElementsByTagNameNS(
                ezcWebdavXmlTool::XML_DEFAULT_NAMESPACE,
                'href'
            );
            foreach ( $hrefs as $href )
            {
                $href->nodeValue = parse_url( $href->nodeValue, PHP_URL_PATH );
            }
        }
        return $xmlDispInfo;
    }
}
?>
