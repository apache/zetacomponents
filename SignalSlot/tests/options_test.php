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

/**
 * Tests the optional options. Default values are tested in the signal collection test file.
 *
 * @package SignalSlot
 * @subpackage Tests
 */
class ezcSignalSlotCollectionOptionsTest extends ezcTestCase
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

    public function testSetOptionsArray()
    {
        $this->giver->signals->setOptions( array( 'signals' => array( 'someSignal' ) ) );
    }

    public function testSetOptionsObject()
    {
        $this->giver->signals->setOptions( new ezcSignalCollectionOptions( array( 'signals' => array( 'someSignal' ) ) ) );
    }

    public function testsetOptionsDirect()
    {
        $this->giver->signals->options = new ezcSignalCollectionOptions( array( 'signals' => array( 'someSignal' ) ) );
    }

    public function testGetOptions()
    {
        $this->assertTrue( $this->giver->signals->options instanceof ezcSignalCollectionOptions );
    }

    public function testOptionSignalsFunctionIsConnectedValid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        $this->assertFalse( $this->giver->signals->isConnected( 'mySignal' ) );
    }

    public function testOptionSignalsFunctionIsConnectedInvalid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        try
        {
            $this->assertFalse( $this->giver->signals->isConnected( 'NoSuchSignal' ) );
        }
        catch ( ezcSignalSlotException $e ){
            return;
        }
        $this->fail( "Did not get exception when using non existent signal" );
    }

    public function testOptionSignalsFunctionEmitValid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        $this->giver->signals->emit( 'mySignal' ); // no exception
    }

    public function testOptionSignalsFunctionEmitInvalid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        try
        {
            $this->giver->signals->emit( 'NoSuchSignal' );
        }
        catch ( ezcSignalSlotException $e ){
            return;
        }
        $this->fail( "Did not get exception when using non existent signal" );
    }


    public function testOptionsSignalsFunctionConnectValid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        $this->giver->signals->connect( "mySignal", array( $this->receiver, "slotSingleParam" ) );
    }

    public function testOptionsSignalsFunctionConnectInvalid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        try
        {
            $this->giver->signals->connect( "noSuchSignal", array( $this->receiver, "slotSingleParam" ) );
        }
        catch ( ezcSignalSlotException $e ){
            return;
        }
        $this->fail( "Did not get exception when using non existent signal" );
    }

    public function testOptionsSignalsFunctionDisconnectValid()
    {
        $this->giver->signals->options->signals = array( 'mySignal' );
        $this->giver->signals->disconnect( "mySignal", array( $this->receiver, "slotSingleParam" ) );
    }

    public function testOptionsSignalsFunctionDisconnectInvalid()
    {
        $this->giver->signals->options->signals = array( 'myignal' );
        try
        {
            $this->giver->signals->disconnect( "noSuchSignal", array( $this->receiver, "slotSingleParam" ) );
        }
        catch ( ezcSignalSlotException $e ){
            return;
        }
        $this->fail( "Did not get exception when using non existent signal" );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcSignalSlotCollectionOptionsTest" );
    }


}

?>
