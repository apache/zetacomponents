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
<head><title>Test 1</title></head>
<body>
<?php
    require_once '../../../Base/src/base.php';

    function __autoload( $className )
    {
        ezcBase::autoload( $className );
    }

if ( ezcInputForm::hasPostData() )
{
?>
<table border="1" align="center">
    <tr><th>Expected</th><th>Result</th></tr>
    <tr>
        <td>
            <pre>
<?php
    echo "Valid properties:\n";
    var_dump( array() );

    echo "Invalid properties:\n";
    var_dump( array( 'test' ) );

    echo "Required properties:\n";
    var_dump( array() );

    echo "Optional properties:\n";
    var_dump( array( 'test' ) );
?>
        </td>
        <td>
            <pre>
<?php
    $def = array( 'test' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'float' ) );
    $form = new ezcInputForm( INPUT_POST, $def );

    echo "Valid properties:\n";
    var_dump( $form->getValidProperties() );

    echo "Invalid properties:\n";
    var_dump( $form->getInvalidProperties() );

    echo "Required properties:\n";
    var_dump( $form->getRequiredProperties() );

    echo "Optional properties:\n";
    var_dump( $form->getOptionalProperties() );
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

<input type="submit" name="submit" value="Go!"/>
</form>
</body>
</html>
<?php
}
?>
