<?php


class ezcTemplateSymbolTable
{
    const VARIABLE = 1;
    const CYCLE = 2;
    const IMPORT = 3;  // USE is a keyword.

    // Messages.
    const SYMBOL_REDECLARATION = "The %s <\$%s> is already declared.";
    const SYMBOL_TYPES_NOT_EQUAL = "The %s <\$%s> is already declared as '%s'.";
    const SYMBOL_NOT_DECLARED = "The symbol <\$%s> is not declared";

    protected $symbols;

    private $errorMessage = "";

    public function __construct()
    {
        $this->symbols = array();
    }

    public function enter($symbol, $type, $allowRedeclaration = false)
    {
        if( isset( $this->symbols[ $symbol ] ) )
        {
            if( $allowRedeclaration )
            {
                $storedType = $this->symbols[ $symbol ];

                if( $type != $storedType )
                {
                    $this->errorMessage = sprintf( self::SYMBOL_TYPES_NOT_EQUAL, self::symbolToString( $type ), $symbol, self::symbolToString( $storedType ) );
                    return false;
                }
            }
            else
            {
                $this->errorMessage = sprintf( self::SYMBOL_REDECLARATION, self::symbolToString( $type ), $symbol );
                return false;
            }
        }

        $this->symbols[ $symbol ] = $type;
        return true;
    }

    public function retrieve( $symbol )
    {
        if( !isset( $this->symbols[ $symbol ] ) )
        {
            $this->errorMessage = sprintf ( self::SYMBOL_NOT_DECLARED, $symbol );
            return false;
        }

        return $this->symbols[ $symbol ];
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public static function symbolToString( $type )
    {
        switch ( $type )
        {
            case self::VARIABLE: return "variable";
            case self::CYCLE: return "cycle";
            case self::IMPORT: return "use";
        }
    }


}


?>
