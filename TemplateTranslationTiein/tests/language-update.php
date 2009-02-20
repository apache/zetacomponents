<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TemplateTranslationTiein
 * @subpackage Tests
 */

/**
 * Test suite for ezcConsoleOutput class.
 * 
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcTemplateTranslationLanguageUpdateTest extends ezcTestCase
{
    private $results;

    /**
     * setUp 
     * 
     * @access public
     */
    protected function setUp()
    {
        $this->tmpDir = $this->createTempDir( "ezcTemplateTranslationLanguageUpdater" );
        $this->tmpDirTranslationFiles = $this->tmpDir . '/translations';
        mkdir( $this->tmpDirTranslationFiles );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function testNewFileDefaultLanguage()
    {
        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;
        self::assertEquals( true, file_exists( $this->tmpDirTranslationFiles . '/en.xml' ) );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles );
        $context = $backend->getContext( 'en', 'test' );
        self::assertEquals( 'test.ezt', $context[0]->filename );
        self::assertEquals( 'twee', $context[1]->original );
        self::assertEquals( 'drie', $context[2]->translation );
        self::assertEquals( 1, $context[3]->status );
        self::assertEquals( 19, $context[4]->line );
    }

    public function testNewFileGivenLanguage()
    {
        $res = `php TemplateTranslationTiein/src/runextractor.php -l nl-nl -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;
        self::assertEquals( true, file_exists( $this->tmpDirTranslationFiles . '/nl-nl.xml' ) );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles );
        $context = $backend->getContext( 'nl-nl', 'test2' );
        self::assertEquals( 'test.ezt', $context[0]->filename );
        self::assertEquals( 'zeven', $context[1]->original );
        self::assertEquals( 'acht', $context[2]->translation );
        self::assertEquals( 1, $context[3]->status );
        self::assertEquals( 36, $context[4]->line );
    }

    public function testNewFileDifferentFormat()
    {
        $res = `php TemplateTranslationTiein/src/runextractor.php -f "tr-[LOCALE].xml" -l nl-nl -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;
        self::assertEquals( true, file_exists( $this->tmpDirTranslationFiles . '/tr-nl-nl.xml' ) );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array ( 'format' => 'tr-[LOCALE].xml' ) );
        $context = $backend->getContext( 'nl-nl', 'test5' );
        self::assertEquals( 'test2.ezt', $context[0]->filename );
        self::assertEquals( 'fourteen', $context[0]->original );
        self::assertEquals( 'fourteen', $context[0]->translation );
        self::assertEquals( 1, $context[0]->status );
        self::assertEquals( 10, $context[0]->line );
    }

    public function testNewElement()
    {
        copy( 'TemplateTranslationTiein/tests/test_files/extractor/test-new-elements/original.xml', "{$this->tmpDirTranslationFiles}/en.xml" );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array( 'keepObsolete' => true ) );
        $manager = new ezcTranslationManager( $backend ); 
        $context = $manager->getContext( 'en', 'test' );
        try
        {
            $tr = $context->getTranslation( 'vier' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationKeyNotAvailableException $e )
        {
            self::assertEquals( "The key 'vier' does not exist in the translation map.", $e->getMessage() );
        }

        $context = $backend->getContext( 'en', 'test' );
        self::assertEquals( 'een', $context[0]->original );
        self::assertEquals( ezcTranslationData::TRANSLATED, $context[0]->status );

        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;

        $context = $backend->getContext( 'en', 'test' );
        self::assertEquals( 'vier', $context[1]->original );
        self::assertEquals( ezcTranslationData::UNFINISHED, $context[1]->status );
        self::assertEquals( ezcTranslationData::TRANSLATED, $context[3]->status );
    }

    public function testNewContext()
    {
        copy( 'TemplateTranslationTiein/tests/test_files/extractor/test-new-elements/original.xml', "{$this->tmpDirTranslationFiles}/en.xml" );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array( 'keepObsolete' => true ) );
        try
        {
            $context = $backend->getContext( 'en', 'test3' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcTranslationContextNotAvailableException $e )
        {
            self::assertEquals( "The context 'test3' does not exist.", $e->getMessage() );
        }

        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;

        $context = $backend->getContext( 'en', 'test3' );
        self::assertEquals( 2, count( $context ) );
        self::assertEquals( 'eleven', $context[0]->translation );
        self::assertEquals( 'twelve', $context[1]->original );
        self::assertEquals( ezcTranslationData::UNFINISHED, $context[0]->status );
        self::assertEquals( ezcTranslationData::UNFINISHED, $context[1]->status );
    }

    public function testRemovedElement()
    {
        copy( 'TemplateTranslationTiein/tests/test_files/extractor/test-new-elements/original.xml', "{$this->tmpDirTranslationFiles}/en.xml" );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array( 'keepObsolete' => true ) );
        $context = $backend->getContext( 'en', 'test' );
        self::assertEquals( 3, count( $context ) );
        self::assertEquals( 'gone', $context[2]->translation );
        self::assertEquals( 'gone', $context[2]->original );
        self::assertEquals( ezcTranslationData::TRANSLATED, $context[2]->status );

        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;

        $context = $backend->getContext( 'en', 'test' );
        self::assertEquals( 6, count( $context ) );
        self::assertEquals( 'gone', $context[5]->translation );
        self::assertEquals( 'gone', $context[5]->original );
        self::assertEquals( ezcTranslationData::OBSOLETE, $context[5]->status );
    }

    public function testRemovedAllElementsInContext()
    {
        copy( 'TemplateTranslationTiein/tests/test_files/extractor/test-new-elements/original.xml', "{$this->tmpDirTranslationFiles}/en.xml" );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array( 'keepObsolete' => true ) );
        $context = $backend->getContext( 'en', 'test0' );
        self::assertEquals( 1, count( $context ) );
        self::assertEquals( 'not used at all', $context[0]->translation );
        self::assertEquals( 'not used at all', $context[0]->original );
        self::assertEquals( ezcTranslationData::TRANSLATED, $context[0]->status );

        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;

        $context = $backend->getContext( 'en', 'test0' );
        self::assertEquals( 1, count( $context ) );
        self::assertEquals( 'not used at all', $context[0]->translation );
        self::assertEquals( 'not used at all', $context[0]->original );
        self::assertEquals( ezcTranslationData::OBSOLETE, $context[0]->status );
    }

    public function testUnObsolete()
    {
        copy( 'TemplateTranslationTiein/tests/test_files/extractor/test-new-elements/original.xml', "{$this->tmpDirTranslationFiles}/en.xml" );

        $backend = new ezcTranslationTsBackend( $this->tmpDirTranslationFiles, array( 'keepObsolete' => true ) );
        $context = $backend->getContext( 'en', 'test5' );
        self::assertEquals( 'test2.ezt', $context[0]->filename );
        self::assertEquals( 'fourteen', $context[0]->original );
        self::assertEquals( 'thirteen', $context[0]->translation );
        self::assertEquals( 2, $context[0]->status );
        self::assertEquals( 6, $context[0]->line );

        $res = `php TemplateTranslationTiein/src/runextractor.php -t TemplateTranslationTiein/tests/test_files/extractor/templates {$this->tmpDirTranslationFiles}`;

        $context = $backend->getContext( 'en', 'test5' );
        self::assertEquals( 'test2.ezt', $context[0]->filename );
        self::assertEquals( 'fourteen', $context[0]->original );
        self::assertEquals( 'thirteen', $context[0]->translation );
        self::assertEquals( 0, $context[0]->status );
        self::assertEquals( 10, $context[0]->line );
    }

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcTemplateTranslationLanguageUpdateTest" );
	}
}
?>
