<?php
require_once '../../../trunk/Base/src/base.php';

function __autoload( $className )
{
    ezcBase::autoload( $className );
}

$db = ezcDbFactory::create( 'mysql://test@localhost/test' );

$schema = ezcDbSchema::createFromDb( $db );
$schema->writeToFile( 'array', '../tests/workflow.dba' );

file_put_contents(
  '../tests/workflow.dba',
  str_replace(
    '<?php return array (',
    '<?php
ezcTestRunner::addFileToFilter( __FILE__ );

return array (',
    file_get_contents('../tests/workflow.dba')
  )
);
?>
