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
class ezcTranslationTsBackendTest extends ezcTestCase
{
    public function testWrongCtorParams()
    {
        try
        {
            new ezcTranslationTsBackend( '' );
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcTranslationNotConfiguredException $e )
        {
            self::assertSame( "Location '' is invalid.", $e->getMessage() );
        }
    }

    public function testConfigSetting()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations', array ( 'format' => 'test-[LOCALE].xml' ) );
        self::assertSame( $backend->options->format, 'test-[LOCALE].xml' );
    }

    public function testConfigSettingAlternative1()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        $backend->setOptions( array ( 'format' => 'test-[LOCALE].xml' ) );
        self::assertSame( $backend->options->format, 'test-[LOCALE].xml' );
    }

    public function testConfigSettingAlternative2()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        $options = new ezcTranslationTsBackendOptions;
        $options->format = 'test-[LOCALE].xml';
        $backend->setOptions( $options );
        self::assertSame( $backend->options->format, 'test-[LOCALE].xml' );
    }

    public function testConfigGetOption()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        $options = new ezcTranslationTsBackendOptions;
        $options->format = 'test-[LOCALE].xml';
        $backend->setOptions( $options );
        $return = $backend->getOptions();
        self::assertSame( $options, $return );
    }

    public function testConfigIssetProperty()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        self::assertSame( false, isset( $backend->broken ) );
        self::assertSame( true, isset( $backend->options ) );
    }

    public function testConfigGetUnknownProperty()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        try
        {
            $value = $backend->broken;
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'broken'.", $e->getMessage() );
        }
    }

    public function testConfigSetUnknownProperty()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        try
        {
            $backend->broken = 42;
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'broken'.", $e->getMessage() );
        }
    }

    public function testConfigSettingBroken1()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        try
        {
            $backend->setOptions( 'broken' );
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value 'broken' that you were trying to assign to setting 'options' is invalid. Allowed values are: instance of ezcTranslationTsBackendOptions.", $e->getMessage() );
        }
    }

    public function testConfigSettingBroken2()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        try
        {
            $backend->setOptions( array ( 'lOcAtIOn' => 'tests/translations' ) );
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcBaseSettingNotFoundException $e )
        {
            self::assertEquals( "The setting 'lOcAtIOn' is not a valid configuration setting.", $e->getMessage() );
        }
    }

    public function testConfigSettingBroken3()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        try
        {
            $backend->options = 'broken';
            self::fail( 'Expected exception was not thrown.' );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value 'broken' that you were trying to assign to setting 'options' is invalid. Allowed values are: instance of ezcTranslationTsBackendOptions.", $e->getMessage() );
        }
    }

    public function testBuildTranslationFileName1()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations' );
        $backend->setOptions( array ( 'format' => 'test-[LOCALE].xml' ) );
        self::assertEquals( 'tests/translations/test-nl-nl.xml', $backend->buildTranslationFileName( 'nl-nl' ) );
    }

    public function testBuildTranslationFileName2()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations/' );
        $backend->setOptions( array ( 'format' => 'test-[LOCALE].xml' ) );
        self::assertEquals( 'tests/translations/test-nl-nl.xml', $backend->buildTranslationFileName( 'nl-nl' ) );
    }

    public function testBuildTranslationFileName3()
    {
        $backend = new ezcTranslationTsBackend( 'tests/translations/[LOCALE]' );
        $backend->setOptions( array ( 'format' => 'translation.xml' ) );
        self::assertEquals( 'tests/translations/nl-nl/translation.xml', $backend->buildTranslationFileName( 'nl-nl' ) );
    }

    public function testOpenTranslationFile()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $xml = $backend->openTranslationFile( 'nl-nl' );
    }

    public function testOpenTranslationFileMissing()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        try
        {
            $xml = $backend->openTranslationFile( 'nl-nl' );
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcTranslationMissingTranslationFileException $e )
        {
            self::assertEquals( "The translation file '/files/nl-nl.xml' does not exist.", str_replace( $currentDir, '', $e->getMessage() ) );
        }
    }

    public function testGetContextNames()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $contextNames = $backend->getContextNames( 'nb-no' );

        self::assertEquals( array( 'contentstructuremenu/show_content_structure', 'design/admin/class/classlist', 'design/admin/class/datatype/browse_objectrelationlist_placement' ), $contextNames );
    }

    public function testGetContext1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nl-nl', 'contentstructuremenu/show_content_structure' );

        $expected = array( new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Knoop ID: %node_id Zichtbaar: %visibility', false, ezcTranslationData::TRANSLATED, 'test.ezt', 85 ) );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextUnfinishedData()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nl-nl', 'design/admin/collaboration' );

        $expected = array();
        $expected[] = new ezcTranslationData( 'Approval', 'Goedkeuring', false, ezcTranslationData::UNFINISHED );
        $expected[] = new ezcTranslationData( 'Approvals', false, false, ezcTranslationData::UNFINISHED );
        self::assertEquals( $expected, $context );
    }

    public function testGetContextObsolete()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nl-nl', 'design/admin/collaboration/group_tree' );

        $expected = array();
        self::assertEquals( $expected, $context );
    }

    public function testGetContextKeepObsolete()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml', 'keepObsolete' => true ) );
        $context = $backend->getContext( 'nl-nl', 'design/admin/collaboration/group_tree' );

        $expected = array(
            new ezcTranslationData( 'Groups', 'Groepen', false, ezcTranslationData::OBSOLETE )
        );
        self::assertEquals( $expected, $context );
    }

    public function testGetMissingContext()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        try
        {
            $context = $backend->getContext( 'nl-nl', 'does/not/exist' );
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'does/not/exist' does not exist.", $e->getMessage() );
        }
    }

    /**
     * Reader tests
     */
    public function testReader1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $backend->initReader( 'nb-no' );
        $backend->next();
        $context = $backend->currentContext();
        $backend->deinitReader();

        $expected = array(
            'contentstructuremenu/show_content_structure',
            array( new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Node-ID: %node_id Synlig/skjult: %visibility', false, ezcTranslationData::TRANSLATED ) ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testReader2()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $backend->initReader( 'nb-no' );
        $backend->next();
        $backend->next();
        $context = $backend->currentContext();
        $backend->deinitReader();

        $expected = array(
            'design/admin/class/classlist',
            array(
                new ezcTranslationData( 'Edit', 'Rediger', false, ezcTranslationData::TRANSLATED ),
                new ezcTranslationData( 'Create a copy of the <%class_name> class.', 'Lag en kopi av klassen <%class_name>.', false, ezcTranslationData::TRANSLATED ), 
            ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testReader3()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $backend->initReader( 'nb-no' );
        $backend->next();
        $backend->next();
        $backend->next();
        $backend->next();
        $valid = $backend->valid();
        $backend->deinitReader();

        self::assertEquals( false, $valid );
    }

    public function testReader4()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $backend->initReader( 'nb-no' );

        $contexts = array();
        $backend->rewind();
        while ( $backend->valid() )
        {
            $contextName = $backend->key();
            $contexts[] = $contextName;
            $backend->next();
        }
        $backend->deinitReader();

        $expected = array (
            'contentstructuremenu/show_content_structure',
            'design/admin/class/classlist',
            'design/admin/class/datatype/browse_objectrelationlist_placement'
        );

        self::assertEquals( $expected, $contexts );
    }

    public function testReader5()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $backend->initReader( 'nb-no' );

        $contexts = array();
        foreach ( $backend as $contextName => $context )
        {
            $contexts[] = $contextName;
        }
        $backend->deinitReader();

        $expected = array (
            'contentstructuremenu/show_content_structure',
            'design/admin/class/classlist',
            'design/admin/class/datatype/browse_objectrelationlist_placement'
        );

        self::assertEquals( $expected, $contexts );
    }

    public function testReaderValid()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        
        self::assertEquals( false, $backend->valid() );
    }

    public function testNonInitException2()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        try
        {
            $backend->current();
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcTranslationReaderNotInitializedException $e )
        {
            self::assertEquals( "The reader is not initialized with the initReader() method.", $e->getMessage() );
        }
    }

    public function testNonInitException3()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );

        try
        {
            $backend->next();
            self::fail( 'Expected exception was not thrown' );
        }
        catch ( ezcTranslationReaderNotInitializedException $e )
        {
            self::assertEquals( "The reader is not initialized with the initReader() method.", $e->getMessage() );
        }
    }

    public function testAddTranslation1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'contentstructuremenu/show_content_structure', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Node-ID: %node_id Synlig/skjult: %visibility', false, ezcTranslationData::TRANSLATED ),
            new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testAddTranslation2()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/nb-no.xml", "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'contentstructuremenu/show_content_structure', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Node-ID: %node_id Synlig/skjult: %visibility', false, ezcTranslationData::TRANSLATED ),
            new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testAddTranslation3()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/nb-no.xml", "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'number_two', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Node-ID: %node_id Synlig/skjult: %visibility', false, ezcTranslationData::TRANSLATED ),
        );

        $context = $backend->getContext( 'nb-no', 'number_two' );
        $expected = array(
            new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        self::assertEquals( $expected, $context );
    }

    public function testAddUpdateHtml()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/html-string.xml", "{$currentDir}/files/translations/html-string.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'this is <b>important</b>', 'Changed', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'html-string' );
        $backend->storeContext( 'context', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'html-string', 'context' );
        $expected = array(
            new ezcTranslationData( 'this is <b>important</b>', 'Changed', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        unlink( "{$currentDir}/files/translations/html-string.test.xml" );

        self::assertEquals( $expected, $context );
    }

    public function testTwoContextsSameStringAddTranslation()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/dup-string.xml", "{$currentDir}/files/translations/dup-string.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Edit', 'Changed', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'dup-string' );
        $backend->storeContext( 'number_two', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'dup-string', 'contentstructuremenu/show_content_structure' );
        $expected = array(
            new ezcTranslationData( 'Edit', 'Rediger', false, ezcTranslationData::TRANSLATED ),
        );
        self::assertEquals( $expected, $context );

        $context = $backend->getContext( 'dup-string', 'number_two' );
        $expected = array(
            new ezcTranslationData( 'Edit', 'Changed', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        self::assertEquals( $expected, $context );

        $context = $backend->getContext( 'dup-string', 'design/admin/class/classlist' );
        $expected = array(
            new ezcTranslationData( 'Edit', 'Rediger', false, ezcTranslationData::TRANSLATED ),
        );
        unlink( "{$currentDir}/files/translations/dup-string.test.xml" );

        self::assertEquals( $expected, $context );
    }

    public function testUpdateTextWithQuotes()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/quotes.xml", "{$currentDir}/files/translations/quotes.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Test quotes: \'test\' "test".', 'CHANGED: Test quotes: \'test\' "test"', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );
        $context[] = new ezcTranslationData( 'Test quotes: "test" \'test\'.', 'CHANGED: Test quotes: "test" \'test\'', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'quotes' );
        $backend->storeContext( 'quotes', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'quotes', 'quotes' );
        $expected = array(
            new ezcTranslationData( 'Test quotes: \'test\'.', 'Test quotes: \'test\'.', '', ezcTranslationData::UNFINISHED, 'test_files/test-quotes.ezt', 9 ),
            new ezcTranslationData( 'Test quotes: "test".', 'Test quotes: "test".', '', ezcTranslationData::UNFINISHED, 'test_files/test-quotes.ezt', 7 ),
            new ezcTranslationData( 'Test quotes: \'test\' "test".', 'CHANGED: Test quotes: \'test\' "test"', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
            new ezcTranslationData( 'Test quotes: "test" \'test\'.', 'CHANGED: Test quotes: "test" \'test\'', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 )
        );
        unlink( "{$currentDir}/files/translations/quotes.test.xml" );

        self::assertEquals( $expected, $context );
    }

    public function testNonInitWriter1()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/nb-no.xml", "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        try
        {
            $backend->storeContext( 'number_two', $context );
            self::assertEquals( "Expected exception not thrown." );
        }
        catch ( ezcTranslationWriterNotInitializedException $e )
        {
            self::assertEquals( "The writer is not initialized with the initWriter() method.", $e->getMessage() );
        }
    }

    public function testNonInitWriter2()
    {
        $currentDir = dirname( __FILE__ );

        // cp for test
        copy( "{$currentDir}/files/translations/nb-no.xml", "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $context = array();
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        try
        {
            $backend->deinitWriter();
            self::assertEquals( "Expected exception not thrown." );
        }
        catch ( ezcTranslationWriterNotInitializedException $e )
        {
            self::assertEquals( "The writer is not initialized with the initWriter() method.", $e->getMessage() );
        }
    }

    public function testChangeTranslation1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        $context[] = new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'contentstructuremenu/show_content_structure', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );

        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testChangeAndAddTranslation1()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        $context[] = new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 );
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 6 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml' ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'contentstructuremenu/show_content_structure', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );

        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 5 ),
            new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::TRANSLATED, 'test.ezt', 6 ),
        );
        self::assertEquals( $expected, $context );
    }

    public function testAddTranslation4()
    {
        $currentDir = dirname( __FILE__ );
        $backend = new ezcTranslationTsBackend( "{$currentDir}/files/translations" );
        $backend->setOptions( array ( 'format' => '[LOCALE].xml' ) );
        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );
        $context[] = new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::OBSOLETE, 'test.ezt', 5 );
        $context[] = new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::UNFINISHED, 'test.ezt', 6 );

        $backend->setOptions( array ( 'format' => '[LOCALE].test.xml', 'keepObsolete' => true ) );
        $backend->initWriter( 'nb-no' );
        $backend->storeContext( 'contentstructuremenu/show_content_structure', $context );
        $backend->deinitWriter();

        $context = $backend->getContext( 'nb-no', 'contentstructuremenu/show_content_structure' );

        unlink( "{$currentDir}/files/translations/nb-no.test.xml" );

        $expected = array(
            new ezcTranslationData( 'Node ID: %node_id Visibility: %visibility', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::OBSOLETE, 'test.ezt', 5 ),
            new ezcTranslationData( 'Test string to be added', 'Test string die wordt toegevoegd', 'comment', ezcTranslationData::UNFINISHED, 'test.ezt', 6 ),
        );
        self::assertEquals( $expected, $context );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTranslationTsBackendTest" );
    }
}

?>
