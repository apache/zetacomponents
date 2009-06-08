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
    protected $classNameMap = array(
        'camelcaseletters.php'     => 'CamelCaseLetters',
        'cebadword.php'            => 'CeBadWord',
        'cemessagecategoryrel.php' => 'CeMessageCategoryRel',
        'debugger.php'             => 'Debugger',
        'liveusertranslations.php' => 'LiveuserTranslations',
    );

    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( 'ezcDatabasePersistentTest' );
        $this->dataDir = dirname( __FILE__ ) . '/data/';
    }

    protected function tearDown()
    {
        $this->removeTempDir();
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

        $this->assertClassesWorking(
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

        $this->assertClassesWorking(
            $dirs['classDir'],
            'test'
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
            'definition_template.ezt',
            $dirs['configDir']
        );

        $this->assertFilesEqual(
            $this->dataDir . '/template_config_noprefix',
            $dirs['configDir']
        );
    }
    
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
            'definition_template.ezt',
            $dirs['configDir']
        );

        $this->assertFilesEqual(
            $this->dataDir . '/template_config_prefix',
            $dirs['configDir']
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
            'definition_template.ezt',
            $dirs['configDir']
        );

        try
        {
            $schemaWriter->write(
                $schema,
                'definition_template.ezt',
                $dirs['configDir']
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

        $d = dir( $this->dataDir . '/template_config_prefix' );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            if ( !touch ( $dirs['configDir'] . '/' . $entry, 12345 ) )
            {
                $this->markTestIncomplete( "Could not touch '$entry' in config dir '{$dirs['configDir']}.'" );
            }
        }

        $schemaWriter->write(
            $schema,
            'definition_template.ezt',
            $dirs['configDir']
        );

        clearstatcache();

        $d = dir( $dirs['configDir'] );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            $this->assertGreaterThan(
                12345,
                filemtime( $dirs['configDir'] . '/' . $entry )
            );
        }
    }

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

    protected function assertClassesWorking( $classDir, $prefix = '' )
    {
        $d = dir( $classDir );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] === '.' )
            {
                continue;
            }
            $className = $prefix . $this->classNameMap[substr( $entry, strlen( $prefix ) )];

            require "{$classDir}/{$entry}";

            $this->assertClassWorking( $className );
        }
    }

    protected function assertClassWorking( $className )
    {
        $obj = new $className();

        $props = $this->readAttribute(
            $obj,
            'properties'
        );

        // Check property get with defaults
        $setProps = $this->assertPropertiesEqual( $obj, $props );
        
        $obj->setState( $setProps );

        // Check propretries set with setState()
        $this->assertPropertiesEqual( $obj, $setProps );

        $this->assertEquals(
            $setProps,
            $this->readAttribute(
                $obj,
                'properties'
            )
        );
    }

    protected function assertPropertiesEqual( $obj, array $props )
    {
        $i        = 0;
        $setProps = array();
        foreach ( $props as $propName => $propValue )
        {
            $this->assertEquals(
                $obj->$propName,
                $propValue
            );

            $setProps[$propName] = $i++;
        }
        return $setProps;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
