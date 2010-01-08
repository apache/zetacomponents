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
    var_dump( array( 'test1', 'test3' ) );

    echo "Invalid properties:\n";
    var_dump( array( 'test2', 'test4' ) );

    echo "Required properties:\n";
    var_dump( array( 'test1') );

    echo "Optional properties:\n";
    var_dump( array( 'test2', 'test3', 'test4' ) );

    echo "isValid:\n";
    var_dump( false );

    echo "Values:\n";
    var_dump( 3.14 );

    try
    {
        throw new ezcInputFormNoValidDataException( "test2" );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage();
    }

    var_dump( 42.4 );
?>
        </td>
        <td>
            <pre>
<?php
    $def = array(
        'test1' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::REQUIRED, 'float' ),
        'test2' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'float' ),
        'test3' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'float' ),
        'test4' => new ezcInputFormDefinitionElement( ezcInputFormDefinitionElement::OPTIONAL, 'int', array( 1, 2 ) ),
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

    echo "isValid:\n";
    var_dump( $form->isValid() );

    echo "Values:\n";
    var_dump( $form->test1 );

    try
    {
        var_dump( $form->test2 );
    }
    catch ( ezcInputFormException $e )
    {
        echo $e->getCode(), ': ', $e->getMessage();
    }

    var_dump( $form->test3 );
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
<input type="text"   name="test1"  value="3.14"/>
<input type="text"   name="test3"  value="42.4"/>
<input type="submit" name="submit" value="Go!"/>
</form>
</body>
</html>
<?php
}
?>
