<?php
/**
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
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */

class ezcTemplateFileExceptionTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateFileExceptionTest" );
    }

    /**
     * Test 'file not found' constructor values
     */
    public function testFileNotFound()
    {
        $e = new ezcTemplateFileNotFoundException( 'packages/templates/pagelayout.tpl' );

        self::assertSame( "The requested template file 'packages/templates/pagelayout.tpl' does not exist.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file not readable' constructor values
     */
    public function testFileNotReadable()
    {
        $e = new ezcTemplateFileNotReadableException( '/dev/nvram' );

        self::assertSame( "The requested template file '/dev/nvram' is not readable.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file not writeable' constructor values
     */
    public function testFileNotWriteable()
    {
        $e = new ezcTemplateFileNotWriteableException( '/dev/cdrom' );

        self::assertSame( "The requested template file '/dev/cdrom' is not writeable.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file failed unlink' constructor values
     */
    public function testFileFailedUnlink()
    {
        $e = new ezcTemplateFileFailedUnlinkException( 'index.php' );

        self::assertSame( "Unlinking template file 'index.php' failed.", $e->getMessage(),
                          'Exception message is not correct' );
    }

    /**
     * Test 'file failed rename' constructor values
     */
    public function testFileFailedRename()
    {
        $e = new ezcTemplateFileFailedRenameException( 'index.php~', 'index.php' );

        self::assertSame( "Renaming template file from 'index.php~' to 'index.php' failed.", $e->getMessage(),
                          'Exception message is not correct' );
    }
}

?>
