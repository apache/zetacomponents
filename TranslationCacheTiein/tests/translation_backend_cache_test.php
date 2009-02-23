<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TranslationCacheTiein
 * @subpackage Tests
 */

/**
 * @package TranslationCacheTiein
 * @subpackage Tests
 */
class ezcTranslationCacheBackendTest extends ezcTestCase
{
    private $cacheObj;

    protected function setUp()
    {
        $this->cacheObj = new ezcCacheStorageFileArray( $this->createTempDir( 'ezcTranslationCacheBackendTest' ) );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Knoop ID: %node_id Zichtbaar: %visibility', false, ezcTranslationData::TRANSLATED )
        );
        $this->cacheObj->store( 'nl-nl/contentstructuremenu/show_content_structure', $expected );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Approval', 'Goedkeuring', false, ezcTranslationData::UNFINISHED );
        $expected[] = new ezcTranslationData( 'Approvals', false, false, ezcTranslationData::UNFINISHED );
        $this->cacheObj->store( 'nl-nl/design/admin/collaboration', $expected );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Groups', 'Groepen', false, ezcTranslationData::OBSOLETE );
        $this->cacheObj->store( 'nl-nl/design/admin/collaboration/group_tree', $expected );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

/*
 * There are no configuration options yet, so comment this test out for now.
    public function testConfigSetting()
    {
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $backend->setOptions( array ( 'location' => 'tests/translations', 'format' => '[LOCALE].xml' ) );
    }
*/
    public function testConfigSettingBroken()
    {
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        try
        {
            $backend->setOptions( array ( 'lOcAtIOn' => 'tests/translations' ) );
        }
        catch ( ezcBaseSettingNotFoundException $e )
        {
            self::assertEquals( "The setting 'lOcAtIOn' is not a valid configuration setting.", $e->getMessage() );
        }
    }

    public function testGetContext1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $context = $backend->getContext( 'nl-nl', 'contentstructuremenu/show_content_structure' );

        $expected = array( new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Knoop ID: %node_id Zichtbaar: %visibility', false, ezcTranslationData::TRANSLATED ) );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextUnfinishedData()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $context = $backend->getContext( 'nl-nl', 'design/admin/collaboration' );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Approval', 'Goedkeuring', false, ezcTranslationData::UNFINISHED );
        $expected[] = new ezcTranslationData( 'Approvals', false, false, ezcTranslationData::UNFINISHED );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextObsolete()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $context = $backend->getContext( 'nl-nl', 'design/admin/collaboration/group_tree' );

        $expected = array();
        self::assertEquals( $expected, $context );
    }

    public function testGetMissingContext()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        try
        {
            $context = $backend->getContext( 'nl-nl', 'does/not/exist' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'does/not/exist' does not exist.", $e->getMessage() );
        }
    }

    /**
     * Writer tests
     */
    public function testWriter1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $backend->initWriter( 'nb-no' );

        $contextName = 'contentstructuremenu/show_content_structure';
        $contextData = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Node-ID: %node_id Synlig/skjult: %visibility', false, ezcTranslationData::TRANSLATED ),
            new ezcTranslationData( 'Approvals', false, false, ezcTranslationData::UNFINISHED ),
            new ezcTranslationData( 'Groups', 'Groepen', false, ezcTranslationData::OBSOLETE ),
        );
        $backend->storeContext( $contextName, $contextData );
        /* Unsetting element 2, as that should not be in the returned context */
        unset( $contextData[2] );

        $storedContext = $backend->getContext( 'nb-no', $contextName );
        self::assertEquals( $contextData, $storedContext );
    }

    public function testNonInitException1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );

        try
        {
            $backend->storeContext( 'dummy', array() );
        }
        catch ( ezcTranslationWriterNotInitializedException $e )
        {
            self::assertEquals( "The writer is not initialized with the initWriter() method.", $e->getMessage() );
        }
    }

    public function testNonInitException2()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );

        try
        {
            $backend->deinitWriter();
        }
        catch ( ezcTranslationWriterNotInitializedException $e )
        {
            self::assertEquals( "The writer is not initialized with the initWriter() method.", $e->getMessage() );
        }
    }

    public function testNonInitException3()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationCacheBackend( $this->cacheObj );
        $backend->initWriter( 'nb-no' );
        $backend->deinitWriter();

        try
        {
            $backend->deinitWriter();
        }
        catch ( ezcTranslationWriterNotInitializedException $e )
        {
            self::assertEquals( "The writer is not initialized with the initWriter() method.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationCacheBackendTest" );
    }
}

?>
