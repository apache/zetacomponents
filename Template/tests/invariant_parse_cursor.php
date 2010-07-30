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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class Invariant_ezcTemplateCursor
{
    private $receiver;

    public function __construct( $text, $position = 0, $line = 1, $column = 0 )
    {
        $this->receiver = new ezcTemplateCursor( $text, $position, $line, $column );
        $args = func_get_args();
        $this->_checkInvariant( '__construct', $args );
    }

    public function _checkInvariant( $functionName, $parameters )
    {
        $parameterText = "";
        foreach ( $parameters as $key => $parameter )
        {
            if ( $key > 0 )
                $parameterText .= ",";
            $parameterText .= str_replace( array( "\r", "\n", "\t" ),
                                           array( "\\r", "\\n", "\\t" ),
                                           var_export( $parameter, true ) );
    }
        ezcTestCase::assertTrue( $this->receiver->line >= 1,
                                 "Invariant <$functionName($parameterText)>: Property <line> should not be less than 1, was <" . $this->receiver->line . ">" );
        ezcTestCase::assertTrue( $this->receiver->column >= 0,
                                 "Invariant <$functionName($parameterText)>: Property <column> should not be less than 0, was <" . $this->receiver->column . ">" );
        ezcTestCase::assertTrue( $this->receiver->position >= 0,
                                 "Invariant <$functionName($parameterText)>: Property <position> should not be less than 0, was <" . $this->receiver->position . ">" );
        ezcTestCase::assertTrue( $this->receiver->position <= strlen( $this->receiver->text ),
                                 "Invariant <$functionName($parameterText)>: Property <position> should not be larger than the text length <" . strlen( $this->receiver->text ) . ">, was <<" . $this->receiver->position . ">" );


        // Check if position, line and column are coherent
        $lines = preg_split( "#\r\n|\r|\n#", substr( $this->receiver->text, 0, $this->receiver->position ) );
        if ( count( $lines ) > 0 )
        {
            $endLine = 1 + count( $lines ) - 1;
            $lastLine = $lines[count( $lines ) - 1];
            $endColumn = strlen( $lastLine );
        }
        else
        {
            $endLine = 1;
            $endColumn = 0;
        }
        ezcTestCase::assertSame( $endLine, $this->receiver->line,
                                 "Invariant <$functionName($parameterText)>: Property <line> does not correlate with the calculated line number (from <position>)." );
        ezcTestCase::assertSame( $endColumn, $this->receiver->column,
                                 "Invariant <$functionName($parameterText)>: Property <line> does not correlate with the calculated line number (from <position>)." );
    }

    public function __call( $functionName, $parameters )
    {
        $this->_checkInvariant( $functionName, $parameters );
        $retval = call_user_func_array( array( $this->receiver, $functionName ), $parameters );
        $this->_checkInvariant( $functionName, $parameters );
        return $retval;
    }

    public function __isset( $name )
    {
        return isset( $this->receiver->$name );
    }

    public function __get( $name )
    {
        return $this->receiver->$name;
    }

    public function __set( $name, $value )
    {
        $this->receiver->$name = $value;
    }

    public function __clone()
    {
        $this->receiver = clone $this->receiver;
    }
}

?>
