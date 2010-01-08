<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
