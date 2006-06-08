<?php
require 'tutorial_autoload.php';

$xmlSchema = ezcDbSchema::createFromFile( 'xml', 'wanted-schema.xml' );
$messages = ezcDbSchemaValidator::validate( $xmlSchema );
foreach ( $messages as $message )
{
    echo $message, "\n";
}
?>
