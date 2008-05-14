<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

include_once( 'Feed/tests/test.php' );

include_once( 'Feed/tests/regression_suite.php' );
include_once( 'Feed/tests/regression_test.php' );

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRss2RegressionParseTest extends ezcFeedRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'regression'
                                        . DIRECTORY_SEPARATOR . 'parse';

        $this->readDirRecursively( $basePath, $this->files, 'in' );

        parent::__construct();
    }

    public static function suite()
    {
        return new ezcFeedRegressionSuite( __CLASS__ );
    }

    protected function cleanForCompare( $expected, $parsed )
    {
        if ( $parsed->updated instanceof ezcFeedElement
             && $parsed->updated->getValue() instanceof DateTime )
        {
            $parsed->updated = 'xxx';
            $expected->updated = 'xxx';
        }

        if ( $parsed->published instanceof ezcFeedElement
             && $parsed->published->getValue() instanceof DateTime )
        {
            $parsed->published = 'xxx';
            $expected->published = 'xxx';
        }

        if ( isset( $parsed->DublinCore )
             && isset( $parsed->DublinCore->date )
             && is_array( $parsed->DublinCore->date ) )
        {
            foreach ( $parsed->DublinCore->date as $date )
            {
                $date->set( (int) $date->getValue()->format( 'U' ) );
            }
        }

        for ( $i = 0; $i < count( $parsed->item ); $i++ )
        {
            $item = $parsed->item[$i];
            $itemExpected = $expected->item[$i];
            if ( $parsed->item[$i]->published !== $expected->item[$i]->published )
            {
                $item->published = time();
                $itemExpected->published = time();
            }

            if ( isset( $item->DublinCore )
                 && isset( $item->DublinCore->date )
                 && is_array( $item->DublinCore->date ) )
            {
                foreach ( $item->DublinCore->date as $date )
                {
                    $date->set( (int) $date->getValue()->format( 'U' ) );
                }
            }
        }
    }

    public function testRunRegression( $file )
    {
        $errors = array();

        $outFile = $this->outFileName( $file, '.in', '.out' );

        try
        {
            $parsed = ezcFeed::parseContent( file_get_contents( $file ) );
            $expected = include_once( $outFile );
            $this->cleanForCompare( $expected, $parsed );
        }
        catch ( ezcFeedException $e )
        {
            $parsed = $e->getMessage();
            $expected = trim( file_get_contents( $outFile ) );
        }
        $this->assertEquals( var_export( $expected, true ), var_export( $parsed, true ), "The " . basename( $outFile ) . " is not the same as the parsed feed from " . basename( $file ) . "." );
    }
}
?>
