<?php
ezcTestRunner::addFileToFilter( __FILE__ );

class Rel1
{
    public $id = null;
    public $fk = null;

    public function setState( array $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    public function getState()
    {
        $result = array();
        $result['id'] = $this->id;
        $result['fk'] = $this->fk;
        return $result;
    }
}

class Rel2 extends Rel1
{
}
?>
