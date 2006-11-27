<?php
/**
 * File containing the Permutation classes.
 *
 * @package
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * A system for generating permutations of possible combinations.
 *
 * @package
 * @version //autogen//
 */

abstract class ezcTemplatePermutation
{
    public function __construct()
    {
        $this->index = 0;
    }

    abstract public function generate();

    abstract public function increase();

    public function reset()
    {
        $this->index = 0;
    }

    static function generateString( $list )
    {
        $str = '';
        for ( $i = 0; $i < count( $list ); ++$i )
        {
            $p = $list[$i];
            if ( is_object( $p ) )
            {
                $str .= $p->generate();
            }
            else
            {
                $str .= $p;
            }
        }
        return $str;
    }

    static function increaseList( $list )
    {
        for ( $i = count( $list ) - 1; $i >= 0; --$i )
        {
            $p = $list[$i];
            if ( is_object( $p ) )
            {
                if ( $p->increase() )
                    return true;
                $p->reset();
            }
        }
        return false;
    }

    static function indentBlock( $text, $indentation )
    {
        $lines = preg_split( "#(\r\n|\r|\n)#", $text, -1, PREG_SPLIT_DELIM_CAPTURE );
        for ( $i = 0; $i < count( $lines ); $i += 2 )
        {
            if ( $i == count( $lines ) - 1 )
                continue;
            $lines[$i] = $indentation . $lines[$i];
        }
        return implode( "", $lines );
    }
}

class ezcTemplatePermutationList extends ezcTemplatePermutation
{
    public function __construct( $list = null )
    {
        parent::__construct();
        $this->list = $list;
    }

    public function generate()
    {
        return self::generateString( $this->list );
    }

    public function increase()
    {
        return self::increaseList( $this->list );
    }
}

class ezcTemplatePermutationAlternative extends ezcTemplatePermutation
{
    public function __construct( $list = null, $indentation = '' )
    {
        parent::__construct();
        $this->list = $list;
        $this->indentation = $indentation;
    }

    public function __clone()
    {
        foreach ( $this->list as $i => $v )
        {
            if ( is_object( $v ) )
            {
                $this->list[$i] = clone $v;
            }
        }
    }

    public function generate()
    {
        $p = $this->list[$this->index];
        if ( is_object( $p ) )
        {
            return self::indentBlock( $p->generate(), $this->indentation );
        }
        else
        {
            return $p;
        }
    }

    public function increase()
    {
        $p = $this->list[$this->index];
        if ( is_object( $p ) )
        {
            if ( $p->increase() )
                return true;
            $p->reset();
        }
        $this->index++;
        return $this->index < count( $this->list );
    }

    public function reset()
    {
        foreach ( $this->list as $p )
        {
            if ( is_object( $p ) )
            {
                $p->reset();
            }
        }
        $this->index = 0;
    }
}

/*class ezcTemplatePermutationOccurence extends ezcTemplatePermutation
{
    public function __construct( $list, $min, $max )
    {
        parent::__construct();
        $this->list = $list;
        $this->min = $min;
        $this->max = $max;
    }

    public function generate()
    {
        $times = $this->min + $this->index;
        if ( $times === 0 )
            return '';

        $str = self::generateString( $this->list );
        return str_repeat( $str, $times );
    }

    public function increase()
    {
        if ( self::increase( $this->list ) )
            return true;
        $this->index++;
        return $this->index <= ( $this->max - $this->min );
    }
}*/

class ezcTemplatePermutationNumber extends ezcTemplatePermutation
{
    public function __construct( $min = false, $max = false )
    {
        parent::__construct();
        $this->min = $min;
        $this->max = $max;
    }

    public function generate()
    {
        return $this->min + $this->index;
    }

    public function increase()
    {
        $this->index++;
        return $this->index <= ( $this->max - $this->min );
    }
}

class ezcTemplatePermutationApp
{
    public $outputToFile;

    public function __construct( $file, $args = false, $dir = false )
    {
        $this->outputToFile = false;
        if ( $dir === false )
        {
            $dir = dirname( __FILE__ ) . "/../regression_tests";
        }
        $this->fd = false;
        $this->dir = $dir;
        $this->file = $file;

        if ( is_array( $args ) )
        {
            foreach( $args as $arg )
            {
                if ( $arg == '--generate-file' )
                    $this->outputToFile = true;
            }
        }

        if ( $this->outputToFile && !file_exists( $dir ) )
        {
            mkdir( $dir, 0777, true );
        }
    }

    public function store( $content, $file = false )
    {
        if ( $file === false )
            $file = $this->dir . '/' . $this->file;

        if ( $this->outputToFile )
        {
            echo "Writing to ", $file, "\n";
            file_put_contents( $file, $content );
        }
        else
        {
            echo basename( $file ), "\n";
            echo $content, "\n";
        }
    }

    public function output( $content )
    {
        if ( $this->outputToFile )
        {
            if ( $this->fd === false )
            {
                $this->fd = fopen( $this->dir . '/' . $this->file, "w" );
            }
            fwrite( $this->fd, $content );
        }
        else
        {
            echo $content;
        }
    }
}

function app( $file, $args, $dir = false )
{
    return new ezcTemplatePermutationApp( $file, $args, $dir );
}

function perm()
{
    $args = func_get_args();
    return new ezcTemplatePermutationList( $args );
}

function alt()
{
    $args = func_get_args();
    return new ezcTemplatePermutationAlternative( $args );
}

function altI()
{
    $args = func_get_args();
    $indent = array_shift( $args );
    return new ezcTemplatePermutationAlternative( $args, $indent );
}

function num( $min = false, $max = false )
{
    return new ezcTemplatePermutationNumber( $min, $max );
}

?>
