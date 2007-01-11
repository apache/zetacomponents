<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalSlot
 * @subpackage Tests
 */

ezcTestRunner::addFileToFilter( __FILE__ );

class TheGiver
{
    public $signals;

    public function __construct( $signalID = null )
    {
        if ( $signalID === null )
        {
            $this->signals = new ezcSignalCollection( __CLASS__ );
        }
        else
        {
            $this->signals = new ezcSignalCollection( $signalID );
        }
    }
}


class TheReceiver
{
    public static $globalFunctionRun = false;
    public static $staticFunctionRun = false;
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

    public static function slotStatic()
    {
        self::$staticFunctionRun = "have a cigar";
    }
}

function slotFunction()
{
    TheReceiver::$globalFunctionRun = "brain damage";
}


?>
