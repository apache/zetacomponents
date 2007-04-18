<?php
ezcTestRunner::addFileToFilter( __FILE__ );

// Relation class for keywords test. Like is the identifier. Both values are ints.
class Where
{
    public $like = null;
    public $update = null;

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
        $result['like'] = $this->like;
        $result['update'] = $this->update;
        return $result;
    }
}

class Like extends Where
{
}
?>
