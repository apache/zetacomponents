<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @subpackage Tests
 */

require_once( "test_classes.php" );

class Fire implements ezcSignalStaticConnectionsBase
{
    public $fired = 0;
    /**
     * Returns all the connections for signals $signal in signal collections
     * with the identifier $identifier.
     *
     * @param string $identifier
     * @param string $signal
     * @return array(int=>callback)
     */
    public function getConnections( $identifier, $signal )
    {
        return array( 50 => array( array($this, 'alwaysFire') ) );
    }

    public function alwaysFire()
    {
        $this->fired++;
    }

}

/**
 * @package PhpGenerator
 * @subpackage Tests
 */
class ezcSignalStaticConnectionsBaseTest extends ezcTestCase
{
    private $giver;
    private $receiver;

    public function testStaticSignalsFromOtherSource()
    {
        $norris = new Fire();
        ezcSignalCollection::setStaticConnectionsHolder( $norris );

        $signals = new ezcSignalCollection();
        $signals->emit( "chuck" );
        $this->assertEquals( 1, $norris->fired );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSignalStaticConnectionsBaseTest" );
    }
}
?>
