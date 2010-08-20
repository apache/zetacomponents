<?php
/**
 * File contaning the ezcTestPrinter class.
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
 * @package UnitTest
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
require_once 'PHPUnit/TextUI/ResultPrinter.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Test printer class.
 *
 * @package UnitTest
 * @version //autogentag//
 */
class ezcTestPrinter extends PHPUnit_TextUI_ResultPrinter
{
    protected $depth = 0;
    protected $maxLength = 0;

    public function startTestSuite( PHPUnit_Framework_TestSuite $suite )
    {
        if ( $this->maxLength == 0 )
        {
            $iterator = new RecursiveIteratorIterator(
              new PHPUnit_Util_TestSuiteIterator( $suite ),
              RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ( $iterator as $item )
            {
                if ( $item instanceof PHPUnit_Framework_TestSuite )
                {
                    $name = $item->getName();

                    if ( $name == '' )
                    {
                        $name = '[No name given]';
                    }
                    else
                    {
                        $name = explode( '::', $name );
                        $name = array_pop( $name );
                    }

                    $this->maxLength = max( $this->maxLength, strlen( $name ) );
                    $item->setName( $name );
                }
            }
        }

        if ( $this->depth > 0 )
        {
            parent::write( "\n" );
        }

        if ( $this->depth == 1 )
        {
            parent::write( "\n" );
        }

        parent::write(
          str_pad(
            str_repeat( '  ', $this->depth++ ) . $suite->getName() . ': ' ,
            40,
            ' ',
            STR_PAD_RIGHT
          )
        );
    }

    public function endTestSuite( PHPUnit_Framework_TestSuite $suite )
    {
        $this->depth--;
    }

    protected function writeProgress( $progress )
    {
        $this->write( $progress );
    }
}
?>
