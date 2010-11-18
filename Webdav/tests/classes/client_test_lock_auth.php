<?php
/**
 * File containing test code for the Webdav component.
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

class ezcWebdavClientTestRfcLockAuth 
    extends ezcWebdavDigestAuthenticatorBase
    implements ezcWebdavAuthorizer, ezcWebdavLockAuthorizer
{
    public $tokenAssignement = array();

    public $credentials = array(
        'ejw' => '',
    );

    public function authenticateAnonymous( ezcWebdavAnonymousAuth $auth )
    {
        return true;
    }

    public function authenticateBasic( ezcWebdavBasicAuth $auth )
    {
        return (
            isset( $this->credentials[$auth->username] )
            && $this->credentials[$auth->username] === $auth->password
        );
    }

    public function authenticateDigest( ezcWebdavDigestAuth $auth )
    {
        return ( isset( $this->credentials[$auth->username] ) );
    }

    public function authorize( $user, $path, $access = ezcWebdavAuthorizer::ACCESS_READ )
    {
        if ( strpos( $path, '/webdav/secret' ) !== false )
        {
            return false;
        }
        return true;
    }

    public function assignLock( $user, $lockToken )
    {
        if ( !isset( $this->tokenAssignement[$user] ) )
        {
            $this->tokenAssignement[$user] = array();
        }
        $this->tokenAssignement[$user][$lockToken] = true;
    }

    public function ownsLock( $user, $lockToken )
    {
        return (
            isset( $this->tokenAssignement[$user] )
            && isset( $this->tokenAssignement[$user][$lockToken] )
        );
    }

    public function releaseLock( $user, $lockToken )
    {
        unset( $this->tokenAssignement[$user][$lockToken] );
    }
}

?>
