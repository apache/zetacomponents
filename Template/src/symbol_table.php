<?php


class ezcTemplateSymbolTable
{

    const VARIABLE = 1;
    const CYCLE = 2;
    const IMPORT = 3;  // USE is a keyword.

    protected $symbols;

    public function __construct()
    {
        $this->symbols = array();
    }

    public function enter($symbol, $type)
    {
        if( isset( $this->symbols[ $symbol ] ) )
        {
            return false;
        }

        $this->symbols[ $symbol ] = $type;
        return true;
    }

    public function retrieve( $symbol )
    {
        return isset( $this->symbols[ $symbol ] ) ? $this->symbols[ $symbol ] : null;
    }
}


?>
