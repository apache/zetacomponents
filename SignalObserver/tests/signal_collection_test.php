<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalObserver
 * @subpackage Tests
 */

class TheGiver
{
    public $signals;

    public function __construct()
    {
        $this->signals = new ezcSignalCollection( __CLASS__ );
    }
}

class TheReceiver
{
    public $stack = array();
    public function slotNoParams1()
    {
        array_push( $this->stack, "slotNoParams1" );
    }

    public function slotNoParams2()
    {
        array_push( $this->stack, "slotNoParams2" );
    }

    public function slotNoParams3()
    {
        array_push( $this->stack, "slotNoParams3" );
    }

    public function slotNoParams4()
    {
        array_push( $this->stack, "slotNoParams4" );
    }

    public function slotNoParams5()
    {
        array_push( $this->stack, "slotNoParams5" );
    }

    public function slotSingleParam( $param1 )
    {
        array_push( $this->stack, $param1 );
    }

    public function slotDoubleParams( $param1, $param2 )
    {
        array_push( $this->stack, "{$param1}{$param2}" );
    }

    public function slotTrippleParams( $param1, $param2, $param3 )
    {
        array_push( $this->stack, "{$param1}{$param2}{$param3}" );
    }
}

/**
 * @package PhpGenerator
 * @subpackage Tests
 * @TODO: test slots with params by reference
 * @TODO: test with invalid priority input
 */
class ezcSignalCollectionTest extends ezcTestCase
{
    private $giver;
    private $receiver;

    public function setUp()
    {
        $this->giver = new TheGiver();
        $this->receiver = new TheReceiver();
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

    public function testAdvancedDisconnectNoSeveralConnections()
    {
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams2" ), 5000 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ) );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->connect( "signal", array( $this->receiver, "slotNoParams1" ), 10 );

        $this->giver->signals->disconnect( "signal", array( $this->receiver, "slotNoParams3" ), 1 );
        $this->giver->signals->emit( "signal" );
        $this->assertEquals( array( "slotNoParams1", "slotNoParams3", "slotNoParams2" ), $this->receiver->stack );
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcSignalCollectionTest" );
    }
}
?>
