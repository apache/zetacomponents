<?php
/**
 * File containing example of using ezcPhpGenerator
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
 * @package PhpGenerator
 */

$generator = new ezcPhpGenerator( "~/file.php" );
$generator->appendCodePiece( "function fibonacci( $number )" );
$generator->appendCodePiece( "{" );

$generator->appendVariable( "lo", 1 );
$generator->appendVariable( "hi", 1 );
$generator->appendVariable( "i", 2 );

$generator->appendWhile( '$i < $number' );
$generator->appendVariable( "hi", "$lo + $hi" );
$generator->appendVariable( "lo", "$hi - $lo" );
$generator->appendEndWhile();
$generator->appendCodePiece( "}" );

?>

The above code will fill the file "~/file.php" with the following contents:

<?php
/**
 * function fibonacci
 */
function fibonacci( $number )
{
    $lo = 1;
    $hi = 1;
    $i = 2;
    while ( $i < $number )
    {
        $hi = $lo + $hi;
        $lo = $hi - $lo;
    }
    return $hi;
}

?>
