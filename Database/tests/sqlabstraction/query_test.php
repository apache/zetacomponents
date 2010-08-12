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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Dummy query impl.
 */
class MyQuery extends ezcQuery
{
    private $query;

    public function __construct()
    {
        parent::__construct( ezcDbInstance::get() );
    }

    // forwarding to make public
    public function id( $id )
    {
        return $this->getIdentifier( $id );
    }

    public function setQuery( $query )
    {
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }
}

/**
 * Tests the base ezcQuery class
 */
class ezcQueryTest extends ezcTestCase
{
    private $q;

    protected function setUp()
    {
        try
        {
            $this->q = new MyQuery();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQueryTest' );
    }

    public function testHasAliases()
    {
        $this->assertEquals( false, $this->q->hasAliases() );
        // create some aliases
        $aliases = array( 'MyTable' => 'my_table',
                          'MyColumn' => 'my_column' );
        $this->q->setAliases( $aliases );
        $this->assertEquals( true, $this->q->hasAliases() );
    }

    public function testAliasExists()
    {
        $aliases = array( 'MyTable' => 'my_table',
                          'MyColumn' => 'my_column' );
        $this->q->setAliases( $aliases );
        $this->assertEquals( 'my_table', $this->q->id( 'MyTable' ) );
    }

    public function testAliasNotExists()
    {
        $this->assertEquals( 'MyTable', $this->q->id( 'MyTable' ) );
    }

    public function testGetIdentifierWithAlias()
    {
        $aliases = array( 'id' => 'table2.id' );
        $this->q->setAliases( $aliases );

        $this->assertEquals( 'table2.id', $this->q->id( 'id' ) );
        $this->assertEquals( 'table1.id', $this->q->id( 'table1.id' ) );
    }

    public function testTableAlias()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT column FROM table1';

        $q->setAliases( array( 't_alias' => 'table1' ) );
        $q->select( 'column' )->from( 't_alias' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testColumnAlias1()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT column1 FROM table1';

        $q->setAliases( array( 'c_alias1' => 'column1' ) );
        $q->select( 'c_alias1' )->from( 'table1' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testColumnAlias2()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT column1, column2 FROM table1';

        $q->setAliases( array( 'c_alias1' => 'column1' ) );
        $q->select( 'c_alias1', 'column2' )->from( 'table1' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testColumnAlias3()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT column1, column2 FROM table1';

        $q->setAliases( array( 'c_alias1' => 'column1', 'c_alias2' => 'column2' ) );
        $q->select( 'c_alias1', 'c_alias2' )->from( 'table1' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testTableAndColumnAlias1()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT column1 FROM table1';

        $q->setAliases( array( 't_column1' => 'column1', 't_alias' => 'table1' ) );
        $q->select( 't_column1' )->from( 't_alias' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testTableAndColumnAlias2()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT table1.column1 FROM table1';

        $q->setAliases( array( 't_column1' => 'column1', 't_alias' => 'table1' ) );
        $q->select( 't_alias.t_column1' )->from( 't_alias' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testTableAndColumnAlias3()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT orders.Recipient FROM orders';

        $q->setAliases( array( 'Order' => 'orders', 'Recipient' => 'orders.company' ) );
        $q->select( 'Order.Recipient' )
          ->from( 'Order' );

        $this->assertEquals( $reference, $q->getQuery() );
    }

    public function testBindValue()
    {
        $value = 42;
        $this->assertEquals( ':test', $this->q->bindValue( $value, ':test' ) );
    }

    public function testBindParam()
    {
        $value = 42;
        $this->assertEquals( ':test', $this->q->bindParam( $value, ':test' ) );
    }

    public function testBindAutoName()
    {
        $value = 2;
        $this->assertEquals( ':ezcValue1', $this->q->bindValue( $value ) );
        $this->assertEquals( ':ezcValue2', $this->q->bindParam( $value ) );
        $this->assertEquals( ':ezcValue3', $this->q->bindValue( $value ) );
    }

    public function testToString()
    {
        $q = ezcDbInstance::get()->createSelectQuery();
        $reference = 'SELECT orders.Recipient FROM orders';

        $q->setAliases( array( 'Order' => 'orders', 'Recipient' => 'orders.company' ) );
        $q->select( 'Order.Recipient' )
          ->from( 'Order' );

        $this->assertEquals( $reference, (string) $q );
        $this->assertEquals( $q->getQuery(), (string) $q );
    }
}
?>
