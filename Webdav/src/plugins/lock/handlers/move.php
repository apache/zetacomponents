<?php
/**
 * File containing the ezcWebdavLockMoveRequestResponseHandler class.
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
 *
 * @access private
 */
/**
 * Handler class for the MOVE request.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockMoveRequestResponseHandler extends ezcWebdavLockCopyRequestResponseHandler
{
    /**
     * Returns all pathes in the move source.
     *
     * This method performs the necessary checks on the source to move. It
     * returns all paths that are to be moved. In case of any violation of the
     * checks, the method must hold and return an instance of
     * ezcWebdavErrorResponse instead of the desired paths.
     * 
     * @return array(string)|ezcWebdavErrorResponse
     */
    protected function getSourcePaths()
    {
        $sourcePathCollector = new ezcWebdavLockCheckPathCollector();

        $violation = $this->tools->checkViolations(
            // Source
            new ezcWebdavLockCheckInfo(
                $this->request->requestUri,
                ezcWebdavRequest::DEPTH_INFINITY,
                $this->request->getHeader( 'If' ),
                $this->request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $sourcePathCollector,
                false // No lock-null allowed
            ),
            // Return on first violation
            true
        );

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }
        return $sourcePathCollector->getPaths();
    }
}

?>
