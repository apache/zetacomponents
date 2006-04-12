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

            return $res;
        }

        return "Invalid cycle";
    }

    public function increment()
    {
        $this->counter = ++$this->counter % $this->size;
    }

    public function decrement()
    {
        if ( --$this->counter  < 0 ) $this->counter = $this->size - 1;
    }

    public function reset()
    {
        $this->counter = 0;
    }
}


?>
