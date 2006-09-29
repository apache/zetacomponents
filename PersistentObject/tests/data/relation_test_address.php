<?php

ezcTestRunner::addFileToFilter( __FILE__ );

require_once dirname( __FILE__ ) . "/relation_test.php";

class RelationTestAddress extends RelationTest
{
    public $id      = null;
    public $street  = null;
    public $zip     = null;
    public $city    = null;
    public $type    = null;


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
            "id"        => $this->id,
            "street"    => $this->street,
            "zip"       => $this->zip,
            "city"      => $this->city,
            "type"      => $this->type,
        );
    }
}

?>
