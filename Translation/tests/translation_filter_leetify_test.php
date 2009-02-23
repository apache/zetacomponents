<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 * @subpackage Tests
 */

/**
 * @package Translation
 * @subpackage Tests
 */
class ezcTranslationFilterLeetifyTest extends ezcTestCase
{
    public function testGetContextWithFilter1()
    {
        $leet = ezcTranslationLeetFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "Group list for you", "Group list for you", false, ezcTranslationData::TRANSLATED );

        $expected = array();
        $expected[] = new ezcTranslationData( "Group list for you", "Gr0up 1is7 4 u", false, ezcTranslationData::TRANSLATED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter2()
    {
        $leet = ezcTranslationLeetFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( 'No items to group.', "No items to group.", false, ezcTranslationData::TRANSLATED );

        $expected = array();
        $expected[] = new ezcTranslationData( 'No items to group.', 'N0 i73ms 2 gr0up.', false, ezcTranslationData::TRANSLATED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter3()
    {
        $leet = ezcTranslationLeetFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "You ate a cookie", "You ate a cookie", false, ezcTranslationData::TRANSLATED );

        $expected = array();
        $expected[] = new ezcTranslationData( "You ate a cookie", "u 8 4 c00ki3", false, ezcTranslationData::TRANSLATED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter4()
    {
        $leet = ezcTranslationLeetFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "The %fruit is round.", "%Fruit er rund.", false, ezcTranslationData::TRANSLATED );

        $expected = array();
        $expected[] = new ezcTranslationData( "The %fruit is round.", "%Fruit 3r rund.", false, ezcTranslationData::TRANSLATED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationFilterLeetifyTest" );
    }
}

?>
