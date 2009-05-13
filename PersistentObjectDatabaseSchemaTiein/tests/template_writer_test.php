<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */

/**
 * @package PersistentObjectDatabaseSchemaTiein
 * @subpackage Tests
 */
class ezcPersistentObjectTemplateSchemaWriterTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( 'ezcDatabasePersistentTest' );
        $this->dataDir = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        // $this->removeTempDir();
    }

    public function getSchema()
    {
        $schema = ezcDbSchema::createFromFile(
            'xml',
            dirname( __FILE__ ) . '/data/webbuilder.schema.xml'
        );
        return $schema;
    }

    public function testPersistentTemplateClassGenerationWithoutPrefixSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );

        $this->assertFilesEqual(
            $this->dataDir . '/template_class_noprefix',
            $dirs['classDir']
        );
    }

    public function testPersistentTemplateClassGenerationWithPrefixSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );
        
        $this->assertFilesEqual(
            $this->dataDir . '/template_class_prefix',
            $dirs['classDir']
        );
    }

    public function testPersistentTemplateClassGenerationOverwriteFailure()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );

        try
        {
            $schemaWriter->write(
                $schema,
                'class_template.ezt',
                $dirs['classDir']
            );
            $this->fail( 'Exception not thrown on existing files and disabled overwrite.' );
        }
        catch ( ezcPersistentObjectSchemaOverwriteException $e ) {}
    }

    public function testPersistentTemplateClassGenerationOverwriteSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => true,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $d = dir( $this->dataDir . '/template_class_prefix' );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            if ( !touch ( $dirs['classDir'] . '/' . $entry, 12345 ) )
            {
                $this->markTestIncomplete( "Could not touch '$entry' in class dir '{$dirs['classDir']}.'" );
            }
        }

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );

        clearstatcache();

        $d = dir( $dirs['classDir'] );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            $this->assertGreaterThan(
                12345,
                filemtime( $dirs['classDir'] . '/' . $entry )
            );
        }
    }

    public function testPersistentTemplateConfigGenerationWithoutPrefixSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'config_template.ezt',
            $dirs['configDir']
        );

        $this->assertFilesEqual(
            $this->dataDir . '/template_config_noprefix',
            $dirs['configDir']
        );
    }
    
    /*

    public function testPersistentTemplateConfigGenerationWithPrefixSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );
        
        $this->assertFilesEqual(
            $this->dataDir . '/template_class_prefix',
            $dirs['classDir']
        );
    }

    public function testPersistentTemplateConfigGenerationOverwriteFailure()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => false,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );

        try
        {
            $schemaWriter->write(
                $schema,
                'class_template.ezt',
                $dirs['classDir']
            );
            $this->fail( 'Exception not thrown on existing files and disabled overwrite.' );
        }
        catch ( ezcPersistentObjectSchemaOverwriteException $e ) {}
    }

    public function testPersistentTemplateConfigGenerationOverwriteSuccess()
    {
        $dirs = $this->setUpDirs();

        $schema = $this->getSchema();
        
        $schemaWriter = new ezcPersistentObjectTemplateSchemaWriter(
            new ezcPersistentObjectTemplateSchemaWriterOptions(
                array(
                    'overwrite'           => true,
                    'classPrefix'         => 'test',
                    'templatePath'        => $dirs['tplDir'],
                    'templateCompilePath' => $dirs['tmpDir'],
                )
            )
        );

        $d = dir( $this->dataDir . '/template_class_prefix' );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            if ( !touch ( $dirs['classDir'] . '/' . $entry, 12345 ) )
            {
                $this->markTestIncomplete( "Could not touch '$entry' in class dir '{$dirs['classDir']}.'" );
            }
        }

        $schemaWriter->write(
            $schema,
            'class_template.ezt',
            $dirs['classDir']
        );

        clearstatcache();

        $d = dir( $dirs['classDir'] );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            $this->assertGreaterThan(
                12345,
                filemtime( $dirs['classDir'] . '/' . $entry )
            );
        }
    }

    */

    protected function assertFilesEqual( $refDir, $dir )
    {
        $d = dir( $refDir );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            $this->assertTrue(
                file_exists( $dir . '/' . $entry ),
                "File $dir/$entry does not exist, but is expected to exist."
            );

            $this->assertEquals(
                file_get_contents( $refDir . '/' . $entry ),
                file_get_contents( $dir . '/' . $entry )
            );
        }
    }

    protected function setUpDirs()
    {
        $origTplDir = dirname( __FILE__ ) . '/../src/template_writer/templates';

        $dirs['tplDir']    = $this->tempDir . '/templates';
        $dirs['classDir']  = $this->tempDir . '/classes';
        $dirs['configDir'] = $this->tempDir . '/config';
        $dirs['tmpDir']    = $this->tempDir . '/tmp';

        mkdir( $dirs['classDir'] );
        mkdir( $dirs['configDir'] );
        mkdir( $dirs['tmpDir'] );

        ezcBaseFile::copyRecursive( $origTplDir, $dirs['tplDir'] );

        return $dirs;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
