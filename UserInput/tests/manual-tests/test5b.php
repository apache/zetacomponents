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
 * @package UserInput
 * @subpackage Tests
 */
?>
<html>
<head><title>Test 3</title></head>
<body>
<?php
var_dump( filter_list() );
$cb1 = filter_input( INPUT_GET, 'test1', filter_id( 'boolean' ), FILTER_NULL_ON_FAILURE );
$cb2 = filter_input( INPUT_GET, 'test2', filter_id( 'boolean' ) );
$int1 = filter_input( INPUT_GET, 'test3', filter_id( 'int' ), FILTER_NULL_ON_FAILURE );
$int2 = filter_input( INPUT_GET, 'test4', filter_id( 'int' ), array( 'flags' => FILTER_NULL_ON_FAILURE, 'options' => array ('max_range' => 42 ) ) );

if ( $cb1 && $cb2 )
{
    echo "both are checked";
}

var_dump( $cb1, $cb2, $int1, $int2 );
?>
<form method="get" align="center">
<input type="checkbox" name="test1" checked="yes"/>
<input type="checkbox" name="test2"/>
<input type="text" name="test3"/>
<input type="text" name="test4"/>
<input type="submit" name="submit" value="Go!"/>
</form>
</body>
</html>
<?php
?>
