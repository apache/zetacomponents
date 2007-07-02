<?php
/**
 *   PHP Brainf*ck compiler
 *   (c) Kristian Hole 2006
 * 
 *   License: 
 *   --
 *     This code is licensed under the Beerware License. 
 *     As long as you keep this notice, do whatever you want with the code.
 *     If you like it, buy the author a beer.
 *     Kristian Hole 2006
 *   --
 * 
 *   RB: The code is adapted, so that it works as CustomBlock.
**/

class BrainFuck implements ezcTemplateCustomBlock, ezcTemplateCustomFunction
{
    public static function getCustomBlockDefinition( $name )
    {
        switch ( $name )
        {
            case "brainfuck": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "emulate";
                $def->hasCloseTag = true;

                $def->requiredParameters = array();
                $def->optionalParameters = array("buffer_size");
                return $def;

            case "bf": 
                $def = new ezcTemplateCustomBlockDefinition();
                $def->class = __CLASS__;
                $def->method = "emulate_inline";
                $def->hasCloseTag = false;

                $def->startExpressionName = "code";
                $def->requiredParameters = array("code");
                $def->optionalParameters = array("buffer_size");
                return $def;
        }
    }

    public static function getCustomFunctionDefinition( $name )
    {
        switch ( $name )
        {
            case "brainfuck": 
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "bfFunction";
                $def->parameters = array( "code", "[buffer_size]" );
                return $def;
        }
    }

    public static function bfFunction( $code, $bufferSize = 1000 )
    {
        return eval( self::compile( $code, "",  $bufferSize ) );
    }


    public static function emulate( $parameters, $code )
    {
        if ( !isset( $parameters["buffer_size"] ) ) $parameters["buffer_size"] = 1000;

        return eval( self::compile( $code, "",  $parameters["buffer_size"] ) );
    }

    public static function emulate_inline( $parameters)
    {
        if ( !isset( $parameters["buffer_size"] ) ) $parameters["buffer_size"] = 1000;

        return eval( self::compile( $parameters["code"], "",  $parameters["buffer_size"] ) );
    }

    public static function compile( $code, $input = '', $bufsize = 1000 )
    {
        $phpcode = <<<ENDL
        \$data = array();
        \$pointer = 0;
        \$bufsize = $bufsize;
        for ( \$i = 0; \$i < \$bufsize; \$i++)
            \$data[\$i]=0;
        \$input='$input';
        \$inputcounter=0;
        \$result = '';
ENDL;

        $length = strlen( $code );
        for ( $ip = 0; $ip < $length; $ip++ )
        {
            switch ( $code[ $ip ] )
            {
                case '<':   $phpcode .= '$pointer++; $pointer = ( $pointer % $bufsize ); ' ."\n"; break;
                case '>':   $phpcode .= '$pointer = ( $pointer > 1 ? $pointer-1 : $pointer+$bufsize-1 );' ."\n"; break;
                case '+':   $phpcode .= '$data[$pointer]++; $data[$pointer] = $data[$pointer] % 255; ' ."\n"; break;
                case '-':   $phpcode .= '$data[$pointer] = ( $data[$pointer] > 0 ? $data[$pointer]-1 : $data[$pointer]+255 );' ."\n"; break;
                case '.':   $phpcode .= '$result .= chr( $data[$pointer] );' ."\n";  break;
                case ',':   $phpcode .= '$data[$pointer]= ( $inputcounter < strlen( $input) ? ord( $input[$inputcounter] ) : 0 ); $inputcounter++;' ."\n"; break;
                case '[':   $phpcode .= 'while ($data[$pointer]) {' ."\n"; break;
                case ']':   $phpcode .= '}' ."\n"; break;
                default: // echo "unknown instruction $code[$ip]\n";
            }
        }
        $phpcode .= 'return $result;';
        return $phpcode;
    }
}

?>
