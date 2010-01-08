<?php
/**
 * File contaning the ezcTestImageCase.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
