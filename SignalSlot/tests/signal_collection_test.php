<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @subpackage Tests
 */

require_once( "test_classes.php" );

/**
 * @package SignalSlot
 * @subpackage Tests
 * @TODO: test slots with params by reference
 * @TODO: test with invalid priority input
 */
class ezcSignalCollectionTest extends ezcTestCase
{
    private $giver;
    private $receiver;

    protected function setUp()
    {
        $this->giver = new TheGiver();
        $this->receiver = new TheReceiver();
        TheReceiver::$globalFunctionRun = false;
        TheReceiver::$staticFunctionRun = false;
        ezcSignalStaticConnections::getInstance()->connections = array();
        ezcSignalCollection::setStaticConnectionsHolder( new EmptyStaticConnections() );
    }

    public function testSignalsBlocked()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ) );
        $this->giver->signals->signalsBlocked = true;
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array(), $this->receiver->stack );
    }

    public function testSingleSignalNoParamsNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1" ), $this->receiver->stack );
    }

    public function testSingleSignalOneParamNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotSingleParam" ) );
        $this->giver->signals->emit( "signal", "on" );
        $this->assertEquals( array( "on" ), $this->receiver->stack );
    }

    public function testSingleSignalTwoParamsNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotDoubleParams" ) );
        $this->giver->signals->emit( "signal", "the", "turning" );
        $this->assertEquals( array( "theturning" ), $this->receiver->stack );
    }

    public function testSingleSignalsThreeParamsNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotTrippleParams" ) );
        $this->giver->signals->emit( "signal", "away", "sorrow", "money" );
        $this->assertEquals( array( "awaysorrowmoney" ), $this->receiver->stack );
    }

    public function testSingleSignalsZeroOrMoreParamsNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotZeroOrMoreParams" ) );
        $this->giver->signals->emit( "signal", "A", "great", "day", "comrades,", "we", "sail", "into", "history!" );
        $this->assertEquals( array( "A great day comrades, we sail into history!" ), $this->receiver->stack );
    }

    public function testSingleSignalsOneOrMoreParamsNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotOneOrMoreParams" ) );
        $this->giver->signals->emit( "signal", "Understanding", "is", "a", "three-edged", "sword." );
        $this->assertEquals( array( "Understanding is a three-edged sword." ), $this->receiver->stack );
    }

    public function testThreeSignalsNoParamNoPri()
    {
        $this->giver->signals->connect( "signal1", array( $this->receiver, "slotNoParams1" ) );
        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams2" ) );
        $this->giver->signals->connect( "signal3", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->emit( "signal2" );
        $this->giver->signals->emit( "signal1" );
        $this->giver->signals->emit( "signal3" );
        $this->assertEquals( array( "slotNoParams2","slotNoParams1","slotNoParams3" ), $this->receiver->stack );
    }

    public function testThreeSlotsNoParamNoPri()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams2","slotNoParams3","slotNoParams1" ), $this->receiver->stack );
    }

    public function testPriorityFiveSlotsSingleSignal()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 1001 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams5" ), 9999 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 1 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams4" ), 999 );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1","slotNoParams4","slotNoParams3", "slotNoParams2", "slotNoParams5" ),
                             $this->receiver->stack );
    }

    public function testPriorityFiveSlotsMultiSignal()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 1001 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams5" ), 9999 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 1 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams4" ), 999 );

        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams1" ), 1001 );
        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams2" ), 9999 );
        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams4" ) );
        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->connect( "signal2", array( $this->receiver, "slotNoParams5" ), 999 );

        $this->giver->signals->emit( "signal" );
        $this->giver->signals->emit( "signal2" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams4", "slotNoParams3", "slotNoParams2", "slotNoParams5",
                                    "slotNoParams3", "slotNoParams5", "slotNoParams4", "slotNoParams1", "slotNoParams2"),
                             $this->receiver->stack );
    }

    public function testGlobalSlot()
    {
        $this->giver->signals->connect( "signal", "slotFunction" );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( "brain damage", TheReceiver::$globalFunctionRun );
    }

    public function testStaticSlot()
    {
        $this->giver->signals->connect( "signal", array( "TheReceiver", "slotStatic" )  );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( "have a cigar", TheReceiver::$staticFunctionRun );
    }

    public function testDisconnect()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ) );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams2", "slotNoParams1" ), $this->receiver->stack );
    }

    public function testAdvancedDisconnectNoPriority()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams2" ), $this->receiver->stack );
    }

    public function testAdvancedDisconnectNoPrioritySeveralConnections()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams3", "slotNoParams1", "slotNoParams2" ), $this->receiver->stack );
    }

    public function testAdvancedDisconnectNoPrioritySeveralConnections2()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 5001 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams3", "slotNoParams2" ), $this->receiver->stack );
    }


    public function testAdvancedDisconnectPriority()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ), 1000 );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams2" ), $this->receiver->stack );
    }

    public function testAdvancedDisconnectPrioritySeveralConnections()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams3", "slotNoParams2" ), $this->receiver->stack );
    }

    public function testIsConnectedNoConnections()
    {
        $this->assertEquals( false, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedNormalConnection()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->assertEquals( true, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedNormalConnectionDisconnected()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->assertEquals( false, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedPriorityConnected()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->assertEquals( true, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedPriorityDisconnected()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->assertEquals( false, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedStaticConnection()
    {
        ezcSignalStaticConnections::getInstance()->connect( 'TheGiver', 'signal', 'slotFunction' );
        $this->assertEquals( true, $this->giver->signals->isConnected( 'signal' ) );
    }

    public function testIsConnectedStaticConnectionDisconnected()
    {
        ezcSignalStaticConnections::getInstance()->connect( 'TheGiver', 'signal', 'slotFunction' );
        ezcSignalStaticConnections::getInstance()->disconnect( 'TheGiver', 'signal', 'slotFunction' );
        $this->assertEquals( false, $this->giver->signals->isConnected( 'signal' ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSignalCollectionTest" );
    }
}
?>
