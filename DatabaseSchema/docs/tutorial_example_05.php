<?php
require 'tutorial_autoload.php';

// create a database schema from an XML file
$xmlSchema = ezcDbSchema::createFromFile( 'xml', 'enterprise.xml' );

// get the tables schema from the database schema
// BY REFERENCE! - otherwise new/deleted tables are NOT updated in the schema
$schema =& $xmlSchema->getSchema();

// add a new table (employees) to the database
$schema['employees'] = new ezcDbSchemaTable(
    array(
        'id' => new ezcDbSchemaField( 'integer', false, true, null, true ),
    ),
    array(
        'primary' => new ezcDbSchemaIndex( array( 'id' => new ezcDbSchemaIndexField() ), true ),
    )
);

// copy the schema of table employees to table persons
$schema['persons'] = clone $schema['employees'];

// delete the table table2
unset( $schema['table2'] );

// add the fields birthday and salary to the table employees
$schema['employees']->fields['birthday'] = new ezcDbSchemaField( 'date' );
$schema['employees']->fields['salary'] = new ezcDbSchemaField( 'integer' );

// modify the type of salary field to be float
$schema['employees']->fields['salary']->type = 'float';

// delete the field salary
unset( $schema['employees']->fields['salary'] );

?>
