<?php

require_once dirname( __FILE__ ) . "/relation_test.php";

class RelationTestEmployer extends RelationTest
{
    public $id   = null;
    public $name = null;

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
            "name" => $this->name,
        );
    }

    public static function __set_state( array $state  )
    {
        $employer = new RelationTestEmployer();
        foreach ( $state as $key => $value )
        {
            $employer->$key = $value;
        }
        return $employer;
    }
}

?>
