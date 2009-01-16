<?php
require_once dirname( __FILE__ ) . "/relation_test.php";

class RelationTestPerson extends RelationTest
{
    public $id        = null;
    public $firstname = null;
    public $surname   = null;
    public $employer  = null;
                   

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
            "firstname" => $this->firstname,
            "surname"   => $this->surname,
            "employer"  => $this->employer,
        );
    }

    public static function __set_state( array $state  )
    {
        $person = new RelationTestPerson();
        foreach ( $state as $key => $value )
        {
            $person->$key = $value;
        }
        return $person;
    }
}

?>
