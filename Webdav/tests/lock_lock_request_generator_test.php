<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
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
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavFileBackendOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockLockRequestGeneratorTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    public function testConstructor()
    {
        $lockReq = new ezcWebdavLockRequest(
            '/some/path'
        );
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $reqGen = new ezcWebdavLockLockRequestGenerator(
            $lockReq,
            $activeLock
        );

        $this->assertAttributeSame(
            $lockReq,
            'issueingRequest',
            $reqGen
        );
        $this->assertAttributeSame(
            $activeLock,
            'activeLock',
            $reqGen
        );
        $this->assertAttributeEquals(
            array(),
            'requests',
            $reqGen
        );
    }

    public function testNotifyPropertyNotAvailable()
    {
        // Setup request generator
        $lockReq = new ezcWebdavLockRequest(
            '/some/path'
        );
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $reqGen = new ezcWebdavLockLockRequestGenerator(
            $lockReq,
            $activeLock
        );

        // Fake PROPFIND response
        $propStatRes = new ezcWebdavPropStatResponse(
            new ezcWebdavBasicPropertyStorage(),
            ezcWebdavResponse::STATUS_200
        );
        $propStatRes->storage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propFindRes = new ezcWebdavPropFindResponse(
            new ezcWebdavResource( '/some/path' ),
            $propStatRes
        );
        
        // Fake result
        $result = new ezcWebdavPropPatchRequest( '/some/path' );
        $result->updates->attach(
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject( 
                    array( $activeLock )
                )
            ),
            ezcWebdavPropPatchRequest::SET
        );

        // Perform notify
        $reqGen->notify( $propFindRes );

        $this->assertAttributeEquals(
            array( $result ),
            'requests',
            $reqGen
        );
    }

    public function testNotifyPropertyAvailable()
    {
        // Setup request generator
        $lockReq = new ezcWebdavLockRequest(
            '/some/path'
        );
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $reqGen = new ezcWebdavLockLockRequestGenerator(
            $lockReq,
            $activeLock
        );

        // Fake PROPFIND response
        $lockDiscoveryProperty =  new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    new ezcWebdavLockDiscoveryPropertyActiveLock(
                        ezcWebdavLockRequest::TYPE_WRITE,
                        ezcWebdavLockRequest::SCOPE_EXCLUSIVE,
                        ezcWebdavRequest::DEPTH_INFINITY,
                        'somone@example.com'
                    )
                )
            )
        );

        $propStatRes = new ezcWebdavPropStatResponse(
            new ezcWebdavBasicPropertyStorage(),
            ezcWebdavResponse::STATUS_200
        );
        $propStatRes->storage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propStatRes->storage->attach(
            $lockDiscoveryProperty
        );
        $propFindRes = new ezcWebdavPropFindResponse(
            new ezcWebdavResource( '/some/path' ),
            $propStatRes
        );
        
        // Fake result
        $newLockDiscoveryProperty = clone $lockDiscoveryProperty;
        $newLockDiscoveryProperty->activeLock->append( $activeLock );
        $result = new ezcWebdavPropPatchRequest( '/some/path' );
        $result->updates->attach(
            $newLockDiscoveryProperty,
            ezcWebdavPropPatchRequest::SET
        );

        // Perform notify
        $reqGen->notify( $propFindRes );

        $this->assertAttributeEquals(
            array( $result ),
            'requests',
            $reqGen
        );
    }

    public function testNotifyPropertyNotFound()
    {
        // Setup request generator
        $lockReq = new ezcWebdavLockRequest(
            '/some/path'
        );
        $activeLock = new ezcWebdavLockDiscoveryPropertyActiveLock();

        $reqGen = new ezcWebdavLockLockRequestGenerator(
            $lockReq,
            $activeLock
        );

        // Fake PROPFIND response
        $propStatRes = new ezcWebdavPropStatResponse(
            new ezcWebdavBasicPropertyStorage(),
            ezcWebdavResponse::STATUS_200
        );
        $propStatRes->storage->attach(
            new ezcWebdavGetEtagProperty()
        );
        $propStatRes2 = new ezcWebdavPropStatResponse(
            new ezcWebdavBasicPropertyStorage(),
            ezcWebdavResponse::STATUS_404
        );
        $propStatRes2->storage->attach(
            new ezcWebdavLockDiscoveryProperty()
        );
        $propFindRes = new ezcWebdavPropFindResponse(
            new ezcWebdavResource( '/some/path' ),
            $propStatRes,
            $propStatRes2
        );
        
        // Fake result
        $result = new ezcWebdavPropPatchRequest( '/some/path' );
        $result->updates->attach(
            new ezcWebdavLockDiscoveryProperty(
                new ArrayObject( 
                    array( $activeLock )
                )
            ),
            ezcWebdavPropPatchRequest::SET
        );

        // Perform notify
        $reqGen->notify( $propFindRes );

        $this->assertAttributeEquals(
            array( $result ),
            'requests',
            $reqGen
        );
    }
}

?>
