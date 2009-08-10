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
class ezcTranslationFilterBorkifyTest extends ezcTestCase
{
    public function testGetContextWithFilter1()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "Group list for '%1'", "Groeplijst voor %1", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( "Group list for '%1'", "[Groop leest for '%1'-a]", false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter2()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( 'No items in group.',  'No items in group.', false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( 'No items in group.',  '[No items in groop.]', false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter3()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "Group tree for '%1'", "Group tree for '%1'", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( "Group tree for '%1'", "[Groop tree for '%1'-a]", false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter4()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( 'Via an auto gehen few goof', "Via an auto gehen few goof", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Via an auto gehen few goof', "[Veea un ooto gehee foo gooff]", false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter5()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( 'Vi gir sow phone booth', "Vi gir sow phone booth", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Vi gir sow phone booth', "[Vee gur soo fone boot]", false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter6()
    {
        $bork = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( 'Attention! Ku Ut sy veg weg', "Attention! Ku Ut sy veg weg", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Attention! Ku Ut sy veg weg', "[Attenshun Koo Oot sai feg veg!]", false, ezcTranslationData::UNFINISHED );

        $bork->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilter7()
    {
        $leet = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "The %fruit is round.", "%Fruit er rund.", false, ezcTranslationData::UNFINISHED );

        $expected = array();
        $expected[] = new ezcTranslationData( "The %fruit is round.", "[The %fruit is roond.]", false, ezcTranslationData::UNFINISHED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextAlreadyTranslated()
    {
        $leet = ezcTranslationBorkFilter::getInstance();
        
        $context = array();
        $context[] = new ezcTranslationData( "The %fruit is round.", "%Fruit er rund.", false, ezcTranslationData::TRANSLATED );

        $expected = array();
        $expected[] = new ezcTranslationData( "The %fruit is round.", "%Fruit er rund.", false, ezcTranslationData::TRANSLATED );

        $leet->runFilter( $context );
        self::assertEquals( $expected, $context );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationFilterBorkifyTest" );
    }
}

?>
