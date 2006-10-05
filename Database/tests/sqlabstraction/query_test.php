<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
}
?>
