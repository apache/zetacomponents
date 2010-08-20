<?php
/**
 * File contaning the ezcTestImageCase.
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
 * @package UnitTest
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Abstract base class for image related test cases.
 *
 * @package UnitTest
 * @version //autogentag//
 */
abstract class ezcTestImageCase extends ezcTestCase
{
    /**
     * Asserts that the compared images are same
     *
     * Uses the compare binary of the imagemagick package to compare to images
     * and will fail if the difference between two images is higher then zero.
     * 
     * @param string $image New image
     * @param string $expectedImage Image to compare with
     * @param string $message Message to append to the fail message
     * @access public
     * @return void
     */
    public function assertImageSame( $expectedImage, $image, $message = '' )
    {
        $constraint = new ezcTestConstraintSimilarImage( $expectedImage );

        if ( ! $constraint->evaluate( $image ) ) {
            self::failConstraint( $constraint, $image, $message );
        }
    }

    /**
     * Asserts that the compared images are similar
     *
     * Uses the compare binary of the imagemagick package to compare to images
     * and will fail if the difference between two images is higher then the
     * defined value.
     *
     * See http://www.imagemagick.org/script/compare.php for details. The 
     * difference is logarithmical scaled.
     * 
     * @param string $image New image
     * @param string $expectedImage Image to compare with
     * @param string $message Message to append to the fail message
     * @param int $maxDifference Maximum difference between images
     * @access public
     * @return void
     */
    public function assertImageSimilar( $expectedImage, $image, $message = '', $maxDifference = 0 )
    {
        $constraint = new ezcTestConstraintSimilarImage( $expectedImage, $maxDifference );

        self::assertThat( $image, $constraint, $message );
    }
}
?>
