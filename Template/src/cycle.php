<?php

class ezcTemplateCycle
{
    private $value = false;

    private $counter = 0;
    private $size;

    public function __construct()
    {
    }

    public function __set( $name, $value )
    {
        if( is_array( $value ) )
        {
            $this->value = $value;
            $this->size = sizeof( $value );

            if( $this->size > 0 ) return;
        }

        $this->value = false;
    }

    public function __get( $name )
    {
        if( $this->value !== false )
        {
            $res = $this->value[ $this->counter ];
            $this->counter = ++$this->counter % $this->size;

            return $res;
        }

        return "Invalid cycle";
    }

    /*
    public function assign( $value )
    {
        $this->value = $value;
    }

    public function toString()
    {
        return $this->value[0];
    }
    */

}


?>
