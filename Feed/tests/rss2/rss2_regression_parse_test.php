<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
        if ( $parsed->published !== 'string'
             && $expected->published !== $parsed->published )
        {
            $parsed->published = 'XXX';
            $expected->published = 'XXX';
        }

        if ( $parsed->updated !== 'string'
             && $expected->updated !== $parsed->updated )
        {
            $parsed->updated = 'YYY';
            $expected->updated = 'YYY';
        }

        for ( $i = 0; $i < count( $expected->items ); $i++ )
        {
            $item = $expected->items[$i];
            if ( $expected->items[$i]->published !== $parsed->items[$i]->published )
            {
                $item->published = time();
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
