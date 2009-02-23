<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
