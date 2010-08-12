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
