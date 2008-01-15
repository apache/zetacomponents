<?php

require_once 'persistent_test_object.php';

class PersistentTestObjectInvalidState extends PersistentTestObject
{
    public $state = null;

    public function getState()
    {
        return $this->state;
    }
}

?>
