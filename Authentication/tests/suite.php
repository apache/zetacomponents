<?php
/**
 * File containing the ezcAuthenticationSuite class.
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "general/authentication_test.php" );
require_once( "session/session_test.php" );
require_once( "filters/group/group_test.php" );
require_once( "filters/group/group_multiple_test.php" );
require_once( "filters/htpasswd/htpasswd_test.php" );
require_once( "filters/ldap/ldap_test.php" );
require_once( "filters/openid/openid_test.php" );
require_once( "filters/openid/openid_file_store_test.php" );
require_once( "filters/token/token_test.php" );
require_once( "filters/typekey/typekey_test.php" );
require_once( "math/bignum_test.php" );
require_once( "url/url_test.php" );

/**
 * @package Authentication
 * @version //autogen//
 * @subpackage Tests
 */
class ezcAuthenticationSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "Authentication" );

        $this->addTest( ezcAuthenticationGeneralTest::suite() );
        $this->addTest( ezcAuthenticationSessionTest::suite() );
        $this->addTest( ezcAuthenticationGroupTest::suite() );
        $this->addTest( ezcAuthenticationGroupMultipleTest::suite() );
        $this->addTest( ezcAuthenticationHtpasswdTest::suite() );
        $this->addTest( ezcAuthenticationLdapTest::suite() );
        $this->addTest( ezcAuthenticationOpenidTest::suite() );
        $this->addTest( ezcAuthenticationOpenidFileStoreTest::suite() );
        $this->addTest( ezcAuthenticationTokenTest::suite() );
        $this->addTest( ezcAuthenticationTypekeyTest::suite() );
        $this->addTest( ezcAuthenticationBignumTest::suite() );
        $this->addTest( ezcAuthenticationUrlTest::suite() );
    }

    public static function suite()
    {
        return new ezcAuthenticationSuite();
    }
}
?>
