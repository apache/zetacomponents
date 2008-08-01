<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

include_once( 'UnitTest/src/regression_suite.php' );
include_once( 'UnitTest/src/regression_test.php' );
include_once( 'Feed/tests/regression_test.php' );

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRss1RegressionGenerateTest extends ezcFeedRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'regression'
                                        . DIRECTORY_SEPARATOR . 'generate';

        $this->readDirRecursively( $basePath, $this->files, 'in' );

        parent::__construct();
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }

    protected function cleanForCompare( $text )
    {
        $text = preg_replace( '@<dc:date.*?>.*?</dc:date>@', '<dc:date>XXX</dc:date>', $text );
        return $text;
    }

    public function testRunRegression( $file )
    {
        $errors = array();

        $outFile = $this->outFileName( $file, '.in', '.out' );
        $expected = trim( file_get_contents( $outFile ) );
        $data = include_once( $file );
        $feed = $this->createFeed( 'rss1', $data );
        try
        {
            $generated = $feed->generate();
            $generated = trim( $this->cleanForCompare( $generated ) );
            $expected = $this->cleanForCompare( $expected );

        }
        catch ( ezcFeedException $e )
        {
            $generated = $e->getMessage();
        }

        $this->assertEquals( $expected, $generated, "The " . basename( $outFile ) . " is not the same as the generated feed from " . basename( $file ) . "." );
    }
}
?>
