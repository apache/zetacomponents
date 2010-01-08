<?php
/**
 * File containing the Permutation classes.
 *
 * @package
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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

    abstract public function replace( $from , $to );

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
            if ( $i == count( $lines ) - 1 &&
                 strlen( $lines[$i] ) == 0 )
                continue;
            $lines[$i] = $indentation . $lines[$i];
        }
        return implode( "", $lines );
    }

    static function column( $text )
    {
        $lines = preg_split( "#(\r\n|\r|\n)#", $text, -1, PREG_SPLIT_DELIM_CAPTURE );
        for ( $i = 0; $i < count( $lines ); $i += 2 )
        {
            if ( $i == count( $lines ) - 1 )
                break;
        }
        $c = strlen( $lines[$i] );
        return $c;
    }

    static public function replaceList( &$list, $from, $to )
    {
        foreach ( $list as $i => $item )
        {
            if ( is_object( $item ) )
            {
                $item->replace( $from, $to );
            }
            else
            {
                $list[$i] = str_replace( $from, $to, $item );
            }
        }
    }
}

class ezcTemplatePermutationList extends ezcTemplatePermutation
{
    public function __construct( $list = null, $indentation = '' )
    {
        parent::__construct();
        $this->list = $list;
        $this->indentation = $indentation;
    }

    public function removeIndex( $index )
    {
        if ( $index < 0 || $index >= count( $this->list ) )
        {
            throw new Exception( "Index $index is out of range [0->" . count( $this->list ) . "]" );
        }
        unset( $this->list[$index] );
        $this->list = array_values( $this->list );
    }

    public function replace( $from , $to )
    {
        self::replaceList( $this->list, $from, $to );
    }

    public function generate()
    {
        return self::indentBlock( self::generateString( $this->list ),
                                  $this->indentation );
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

    public function removeIndex( $index )
    {
        if ( $index < 0 || $index >= count( $this->list ) )
        {
            throw new Exception( "Index $index is out of range [0->" . count( $this->list ) . "]" );
        }
        unset( $this->list[$index] );
        $this->list = array_values( $this->list );
    }

    public function replace( $from , $to )
    {
        self::replaceList( $this->list, $from, $to );
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

    public function replace( $from , $to )
    {
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

class ezcTemplatePermutationIndentChild extends ezcTemplatePermutation
{
    public function __construct( ezcTemplatePermutation $child, $indentation )
    {
        parent::__construct();
        $this->child = $child;
        $this->indentation = $indentation;
    }

    public function replace( $from , $to )
    {
        $this->child->replace( $from, $to );
    }

    public function generate()
    {
        $p = $this->child;
        if ( is_object( $p ) )
        {
            $text = $p->generate();
        }
        else
        {
            $text = $p;
        }
        return self::indentBlock( $text,
                                  $this->indentation );
    }

    public function increase()
    {
        $p = $this->child;
        if ( is_object( $p ) )
        {
            return $p->increase();
        }
        return false;
    }

    public function reset()
    {
        $p = $this->child;
        if ( is_object( $p ) )
        {
            $p->reset();
        }
    }
}

class ezcTemplatePermutationAlternativeMaster extends ezcTemplatePermutation
{
    public function __construct( array $slaves )
    {
        parent::__construct();
        $this->slaves = $slaves;
        $this->slaveIndex = count( $this->slaves ) - 1;
        if ( count( $this->slaves ) == 0 )
        {
            throw new Exception( "Slave list cannot be empty" );
        }
        foreach ( $this->slaves as $i => $slave )
        {
            if ( !$slave instanceof ezcTemplatePermutationAlternativeSlave )
            {
                throw new Exception( "Slave entry {$i} is not an instance of ezcTemplatePermutationAlternativeSlave" );
            }
        }
    }

    public function removeIndex( $index )
    {
        if ( $index < 0 || $index >= count( $this->slaves ) )
        {
            throw new Exception( "Index $index is out of range [0->" . count( $this->slaves ) . "]" );
        }
        unset( $this->slaves[$index] );
        $this->slaves = array_values( $this->slaves );
    }

    public function __clone()
    {
        foreach ( $this->slaves as $i => $v )
        {
            if ( is_object( $v ) )
            {
                $this->slaves[$i] = clone $v;
            }
        }
    }

    public function replace( $from , $to )
    {
        self::replaceList( $this->slaves, $from, $to );
    }

    public function generate()
    {
//        echo "master::generate(): si: {$this->slaveIndex}, sc: " . count( $this->slaves ) . "\n";
        $p = $this->slaves[0];
        if ( is_object( $p ) )
        {
            return $p->generate();
        }
        return $p;
    }

    public function increase()
    {
//        echo "master::increase(): si: {$this->slaveIndex}, sc: " . count( $this->slaves ) . "\n";

        for ( $i = count( $this->slaves ) - 1; $i >= 0; --$i )
        {
            $p = $this->slaves[$i];
            if ( is_object( $p ) )
            {
                if ( $p->increaseSlave() )
                {
//                    echo "master::increase(): increaseSlave() is true\n";
                    return true;
                }
//                echo "master::increase(): increaseSlave() is false\n";
                $p->resetSlave();
            }
        }

        foreach ( $this->slaves as $slave )
        {
            $slave->index++;
        }
        $ret = $this->slaves[0]->index < count( $this->slaves[0]->list );
//        echo "master::increase()#3: ret: '$ret', si: {$this->slaveIndex}, sc: " . count( $this->slaves ) . "\n";
        return $ret;

    }

    public function reset()
    {
        foreach ( $this->slaves as $slave )
        {
            $slave->resetSlaves();
        }
    }
}

class ezcTemplatePermutationAlternativeSlave extends ezcTemplatePermutation
{
    public function __construct( $list )
    {
        parent::__construct();
        $this->list = $list;
        $this->index = 0;
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

    public function removeIndex( $index )
    {
        if ( $index < 0 || $index >= count( $this->list ) )
        {
            throw new Exception( "Index $index is out of range [0->" . count( $this->list ) . "]" );
        }
        unset( $this->list[$index] );
        $this->list = array_values( $this->list );
    }

    public function replace( $from , $to )
    {
        self::replaceList( $this->list, $from, $to );
    }

    public function generate()
    {
        $p = $this->list[$this->index];
        if ( is_object( $p ) )
        {
            return $p->generate();
        }
        return $p;
    }

    public function increaseSlave()
    {
//        echo "slave::increaseSlave(): i: {$this->index}\n";
        $p = $this->list[$this->index];
        if ( is_object( $p ) )
        {
            return $p->increase();
        }
        return false;
    }

    public function increase()
    {
        // Slaves do not control the increase(), this is up to the master.
//        echo "slave::increase(): i: {$this->index}\n";
        return false;
    }

    public function setIndex( $index )
    {
//        echo "slave::setIndex( $index )\n";
        if ( $index >= count( $this->list ) )
        {
            throw new Exception( "New index {$index} is out of bounds (" . count( $this->list ) . ")" );
        }
        $this->index = $index;
    }

    public function resetSlave()
    {
        $p = $this->list[$this->index];
        if ( is_object( $p ) )
        {
            return $p->reset();
        }
    }

    public function resetSlaves()
    {
        foreach ( $this->list as $p )
        {
            if ( is_object( $p ) )
            {
                return $p->reset();
            }
        }
        $this->index = 0;
    }

    public function reset()
    {
        // Slaves do not control the reset(), this is up to the master.
        return false;
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
            foreach ( $args as $arg )
            {
                if ( $arg == '--generate-file' )
                    $this->outputToFile = true;
            }
        }
    }

    public function store( $content, $file = false )
    {
        if ( $file === false )
            $file = $this->dir . '/' . $this->file;

        if ( $this->outputToFile )
        {
            if ( !file_exists( dirname( $file ) ) )
            {
                mkdir( dirname( $file ), 0777, true );
            }

            echo "Writing to ", $file, "\n";
            file_put_contents( $file, $content );
            return $file;
        }
        else
        {
            echo basename( $file ), "\n";
            echo $content, "\n";
            return false;
        }
    }

    public function output( $content )
    {
        if ( $this->outputToFile )
        {
            if ( $this->fd === false )
            {
                $file = $this->dir . '/' . $this->file;
                if ( !file_exists( dirname( $file ) ) )
                {
                    mkdir( dirname( $file ), 0777, true );
                }
                $this->fd = fopen( $file, "w" );
            }
            fwrite( $this->fd, $content );
        }
        else
        {
            echo $content;
        }
    }

    public function close()
    {
        if ( $this->outputToFile )
        {
            if ( $this->fd === false )
            {
                throw new Exception( "File has not yet been opened" );
            }
            echo "Writing to ", $this->dir . "/" . $this->file, "\n";
            fclose( $this->fd );
            $this->fd = false;
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

function permI()
{
    $args = func_get_args();
    $indent = array_shift( $args );
    return new ezcTemplatePermutationList( $args, $indent );
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

function indent( $child, $indentation )
{
    return new ezcTemplatePermutationIndentChild( $child, $indentation );
}

function num( $min = false, $max = false )
{
    return new ezcTemplatePermutationNumber( $min, $max );
}

function altMaster()
{
    $slaves = func_get_args();
    return new ezcTemplatePermutationAlternativeMaster( $slaves );
}

function altSlave()
{
    $list = func_get_args();
    return new ezcTemplatePermutationAlternativeSlave( $list );
}

?>
