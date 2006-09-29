<?php

ezcTestRunner::addFileToFilter( __FILE__ );

require_once dirname( __FILE__ ) . "/relation_test.php";

class RelationTestEmployer extends RelationTest
{
    public $id      = null;
    public $name    = null;

    public function setState( array $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    public function getState()
    {
        return array(
            "id"   => $this->id,
            "name" => $this->firstname,
        );
    }
}

?>
