<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */

/**
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */
class ezcTreeXmlWithDbStorageTest extends ezcTestCase
{
    protected function setUp()
    {
        static $i = 0;

        $this->tempDir = $this->createTempDir( __CLASS__ . sprintf( '_%03d_', ++$i ) ) . '/';
        try
        {
            $this->dbh = ezcDbInstance::get();
            $this->removeTables();
            $this->loadSchemas();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
        $this->store = new ezcTreeDbExternalTableDataStore( $this->dbh, 'dataFrom', 'id', 'data' );
    }

    public function teardown()
    {
        $this->removeTempDir();
    }

    private function loadSchemas()
    {
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . "/files/all-types.dba" );
        $schema->writeToDb( $this->dbh );
    }

    protected function removeTables()
    {
        try
        {
            foreach ( array( 'materialized_path', 'nested_set', 'parent_child', 'dataFrom', 'dataTo' ) as $table )
            {
                $this->dbh->exec( "DROP TABLE $table" );
            }
        }
        catch ( Exception $e )
        {
            // ignore
        }
    }

    protected function addTestData( $tree )
    {
        $primates = array(
            'Hominoidea' => array(
                'Hylobatidae' => array(
                    'Hylobates' => array(
                        'Lar Gibbon',
                        'Agile Gibbon',
                        'Müller\'s Bornean Gibbon',
                        'Silvery Gibbon',
                        'Pileated Gibbon',
                        'Kloss\'s Gibbon',
                    ),
                    'Hoolock' => array(
                        'Western Hoolock Gibbon',
                        'Eastern Hoolock Gibbon',
                    ),
                    'Symphalangus' => array(),
                    'Nomascus' => array(
                        'Black Crested Gibbon',
                        'Eastern Black Crested Gibbon',
                        'White-cheecked Crested Gibbon',
                        'Yellow-cheecked Gibbon',
                    ),
                ),
                'Hominidae' => array(
                    'Pongo' => array(
                        'Bornean Orangutan',
                        'Sumatran Orangutan',
                    ), 
                    'Gorilla' => array(
                        'Western Gorilla' => array(
                            'Western Lowland Gorilla',
                            'Cross River Gorilla',
                        ),
                        'Eastern Gorilla' => array(
                            'Mountain Gorilla',
                            'Eastern Lowland Gorilla',
                        ),
                    ), 
                    'Homo' => array(
                        'Homo Sapiens' => array(
                            'Homo Sapiens Sapiens',
                            'Homo Superior'
                        ),
                    ),
                    'Pan' => array(
                        'Common Chimpanzee',
                        'Bonobo',
                    ),
                ),
            ),
        );

        $root = $tree->createNode( 'Hominoidea', 'Hominoidea' );
        $tree->setRootNode( $root );

        $this->addChildren( $root, $primates['Hominoidea'] );
    }

    private function fixId( $id )
    {
        return preg_replace( '/[^A-Z0-9_]/i', '_', $id );
    }

    private function addChildren( ezcTreeNode $node, array $children )
    {
        foreach( $children as $name => $child )
        {
            if ( is_array( $child ) )
            {
                $newNode = $node->tree->createNode( $this->fixId( $name ), $name );
                $node->addChild( $newNode );
                $this->addChildren( $newNode, $child );
            }
            else
            {
                $newNode = $node->tree->createNode( $this->fixId( $child ), $child );
                $node->addChild( $newNode );
            }
        }
    }

    public function testTreeDbStorage()
    {
        $tree = ezcTreeXml::create( $this->tempDir . 'testDbStorage.xml', $this->store );
        $this->addTestData( $tree );
        self::assertSame( "Western Hoolock Gibbon", $tree->fetchNodeById( "Western_Hoolock_Gibbon" )->data );

        // start over
        $tree = new ezcTreeXml( $this->tempDir . 'testDbStorage.xml', $this->store );
        self::assertSame( "Western Hoolock Gibbon", $tree->fetchNodeById( "Western_Hoolock_Gibbon" )->data );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeXmlWithDbStorageTest" );
    }
}

?>
