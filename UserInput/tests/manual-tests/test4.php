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
 * @package UserInput
 * @subpackage Tests
 */
?>
<?php header('Content-type: text/html; charset=iso-8859-1'); ?>
<html>
<head><title>Test 4</title></head>
<body>
<?php
require_once '../../../Base/src/base.php';

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

if ( count( $_POST ) )
{
?>
<table border="1" align="center">
    <tr><th>Expected</th><th>Result</th></tr>
    <tr>
        <td>
            <pre>
<?php
    echo "Valid properties:\n";
    var_dump( array( 'test1', 'test3' ) );

    echo "Invalid properties:\n";
    var_dump( array( 'test2' ) );

    echo "Required properties:\n";
    var_dump( array( 'test1') );

    echo "Optional properties:\n";
    var_dump( array( 'test2', 'test3' ) );

    echo "Values:\n";
?>
        </td>
        <td>
            <pre>
<?php
    $def = array(
        'test1' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'string', FILTER_FLAG_STRIP_HIGH ),
        'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 42 ) ),
        'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 'min_range' => 42 ) ),
    );
    $form = new ezcInputForm( INPUT_POST, $def );

    echo "Valid properties:\n";
    var_dump( $form->getValidProperties() );

    echo "Invalid properties:\n";
    var_dump( $form->getInvalidProperties() );

    echo "Required properties:\n";
    var_dump( $form->getRequiredProperties() );

    echo "Optional properties:\n";
    var_dump( $form->getOptionalProperties() );

    echo "Values:\n";

    var_dump( $form->hasValidData( 'test1' ) );
    var_dump( $form->test1 );

    try
    {
        var_dump( $form->getUnsafeRawData( 'test1' ) );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }
    echo "<hr/>\n";

    var_dump( $form->hasValidData( 'test2' ) );
    try
    {
        var_dump( $form->test2 );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }

    try
    {
        var_dump( $form->getUnsafeRawData( 'test2' ) );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }
    echo "<hr/>\n";

    var_dump( $form->hasValidData( 'test3' ) );
    try
    {
        var_dump( $form->test3 );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }

    try
    {
        var_dump( $form->getUnsafeRawData( 'test3' ) );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }
    echo "<hr/>\n";

    var_dump( $form->hasValidData( 'test4' ) );
    try
    {
        var_dump( $form->test4 );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }

    try
    {
        var_dump( $form->getUnsafeRawData( 'test4' ) );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage(), "\n";
    }
?>
        </td>
    </tr>
</table>
</body>
</html>
<?php
}
else
{
?>
<form method="post" align="center">
<input type="text"   name="test1"  value="blåbærøl"/>
<input type="text"   name="test2"  value="40"/>
<input type="text"   name="test3"  value="142"/>
<input type="submit" name="submit" value="Go!"/>
</form>
</body>
</html>
<?php
}
?>
