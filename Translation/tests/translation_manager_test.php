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
class ezcTranslationManagerTest extends ezcTestCase
{
    public function testGetContext()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $trm = new ezcTranslationManager( $backend );
        $context = $trm->getContext( 'nl-nl', 'contentstructuremenu/show_content_structure' );

        $expected = new ezcTranslation( array( new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Knoop ID: %node_id Zichtbaar: %visibility', false, ezcTranslationData::TRANSLATED, 'test.ezt', 85 ) ) );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextCached()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $trm = new ezcTranslationManager( $backend );
        $expected = new ezcTranslation( array( new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Knoop ID: %node_id Zichtbaar: %visibility', false, ezcTranslationData::TRANSLATED, 'test.ezt', 85 ) ) );

        $context1 = $trm->getContext( 'nl-nl', 'contentstructuremenu/show_content_structure' );
        self::assertEquals( $expected, $context1 );
        $context2 = $trm->getContext( 'nl-nl', 'contentstructuremenu/show_content_structure' );
        self::assertEquals( $expected, $context2 );
        self::assertSame( $context1, $context2 );
    }

    public function testGetContextWithFilter()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $fillin = ezcTranslationComplementEmptyFilter::getInstance();
        
        $trm = new ezcTranslationManager( $backend );
        $trm->addFilter( $fillin );
        $context = $trm->getContext( 'nl-nl', 'design/admin/collaboration/group/view/list' );

        $expected = array();
        $expected[] = new ezcTranslationData( "Group list for '%1'", "Groeplijst voor %1", false, ezcTranslationData::TRANSLATED );
        $expected[] = new ezcTranslationData( 'No items in group.', 'No items in group.', false, ezcTranslationData::UNFINISHED );
        $expected[] = new ezcTranslationData( "Group tree for '%1'", "Group tree for '%1'", false, ezcTranslationData::UNFINISHED );
        $expected = new ezcTranslation( $expected );

        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithFilters()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $leet = ezcTranslationLeetFilter::getInstance();
        $fillin = ezcTranslationComplementEmptyFilter::getInstance();
        
        $trm = new ezcTranslationManager( $backend );
        $trm->addFilter( $fillin );
        $trm->addFilter( $leet );
        $context = $trm->getContext( 'nl-nl', 'design/admin/content/browse_bookmark' );

        $expected = array();
        $expected[] = new ezcTranslationData( "Choose items to bookmark", "Ki3s i73ms 0m 23 73 v03g3n 44n uw f4v0ri373n", false, ezcTranslationData::TRANSLATED );
        $expected[] = new ezcTranslationData( "Select the items that you want to bookmark using the checkboxes and click \"OK\".", "S313c7 7h3 i73ms 7h47 u w4n7 2 b00km4rk using 7h3 ch3ckb0x3s 4nd c1ick \"0K\".", false, ezcTranslationData::UNFINISHED );
        $expected[] = new ezcTranslationData( "Navigate using the available tabs (above), the tree menu (left) and the content list (middle).", "N4vig8 using 7h3 4v4i14b13 74bs (4b0v3), 7h3 7r33 m3nu (13f7) 4nd 7h3 c0n73n7 1is7 (midd13).", false, ezcTranslationData::UNFINISHED );
        $expected = new ezcTranslation( $expected );

        self::assertEquals( $expected, $context );
    }

    public function testGetContextWithObsolete()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $fillin = ezcTranslationComplementEmptyFilter::getInstance();
        
        $trm = new ezcTranslationManager( $backend );
        $trm->addFilter( $fillin );
        $context = $trm->getContext( 'nl-nl', 'design/admin/collaboration/view/summary' );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Item list', 'Lijst met items', false, ezcTranslationData::TRANSLATED );
        $expected = new ezcTranslation( $expected );

        self::assertEquals( $expected, $context );
    }

    public function testGetContextMissing()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        $fillin = ezcTranslationComplementEmptyFilter::getInstance();
        
        $trm = new ezcTranslationManager( $backend );
        $trm->addFilter( $fillin );

        try
        {
            $context = $trm->getContext( 'nl-nl', 'design/admin/collaboration/admin/view/summary' );
            self::fail( 'Expected Exception was not thrown' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'design/admin/collaboration/admin/view/summary' does not exist.", $e->getMessage() );
        }

    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationManagerTest" );
    }
}

?>
