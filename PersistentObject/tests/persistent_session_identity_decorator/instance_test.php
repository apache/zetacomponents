<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Test the instance class with ezcPersistentSessionIdentityDecorator.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorInstanceTest extends ezcTestCase
{
    private $default;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
    }

    protected function getSession()
    {
        $manager = new ezcPersistentCodeManager(
            dirname( __FILE__ ) . "/../data/"
        );
        return new ezcPersistentSession(
            ezcDbInstance::get(),
            $manager
        );
    }

    protected function getSessionDecorator( $session )
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $session->definitionManager
        );

        return new ezcPersistentSessionIdentityDecorator(
            $session,
            $idMap
        );

    }

    public function testSetWithoutIdentifier()
    {
        $session = $this->getSessionDecorator(
            $this->getSession()
        );

        ezcPersistentSessionInstance::set( $session );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get()
        );
    }

    public function testSetWithIdentifier()
    {
        $session = $this->getSessionDecorator(
            $this->getSession()
        );

        ezcPersistentSessionInstance::set( $session, 'foobar' );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get( 'foobar' )
        );
    }

    public function testSetWithIdentifierMixed()
    {
        $session          = $this->getSession();
        $sessionDecorator = $this->getSessionDecorator( $session );

        ezcPersistentSessionInstance::set( $session, 'session' );
        ezcPersistentSessionInstance::set( $sessionDecorator, 'decorator' );

        $this->assertSame(
            $session,
            ezcPersistentSessionInstance::get( 'session' )
        );
        $this->assertSame(
            $sessionDecorator,
            ezcPersistentSessionInstance::get( 'decorator' )
        );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}

?>
