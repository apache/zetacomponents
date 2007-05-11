<?php

ezcTestRunner::addFileToFilter( __FILE__ );

require_once dirname( __FILE__ ) . "/relation_test_person.php";

class RelationTestSecondPerson extends RelationTestPerson
{
}

?>
