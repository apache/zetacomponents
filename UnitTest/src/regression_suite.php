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
 * @package UnitTest
 */

/**
 * @package UnitTest
 */
class ezcTestRegressionSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct( $theClass = '', $name = '' )
    {
        $argumentsValid = false;

        if ( is_object( $theClass ) &&
             $theClass instanceof ReflectionClass )
        {
             $argumentsValid = true;
        }
        else if ( is_string( $theClass )
                  && $theClass !== ''
                  && class_exists( $theClass, false ) )
        {
            $argumentsValid = true;

            if ( $name == '' )
            {
                $name = $theClass;
            }

            $theClass = new ReflectionClass( $theClass );
        }
        else if ( is_string( $theClass ) )
        {
            $this->setName( $theClass );
            return;
        }

        if ( !$argumentsValid )
        {
            throw new InvalidArgumentException();
        }

        if ( $name != '' )
        {
            $this->setName( $name );
        }
        else
        {
            $this->setName( $theClass->getName() );
        }

        $constructor = $theClass->getConstructor();

        if ( $constructor !== null &&
             !$constructor->isPublic() )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'Class "%s" has no public constructor.',
                        $theClass->getName()
                        )
                    )
                );

            return;
        }

        $names = array();
/*
        if ( $theClass->getName() !== 'ezcTestRegressionTest'
             && !$theClass->isSubclassOf( 'ezcTestRegressionTest' ) )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'Class "%s" is not a subclass of ezcTestRegressionTest.',
                        $theClass->getName()
                        )
                    )
                );
        }
*/
        $mainTest = $theClass->newInstance();
        $files = $mainTest->getFiles();

        foreach ( $files as $fileEntry )
        {
            $this->addRegressionTestFile( $fileEntry['file'], $mainTest );
        }

        $tests = $this->tests();
        if ( empty( $tests ) )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'No regression tests found in class "%s".',
                        $theClass->getName()
                        )
                    )
                );
        }
    }

    public function addRegressionTestFile( $file, $mainTest )
    {
        $test = clone $mainTest;
        $test->setCurrentFile( $file );
        $this->addTest( $test );
    }
}
?>
