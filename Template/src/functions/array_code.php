<?php
/**
 * File containing the ezcTemplateArray class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateArray
{

    // array_append( $a, $v1 [, $v2 ...] ) ( QList::append() )::
    // value count > 1 ? array_push( $a, $v1 [, $v2 ...] ) : $a[] = $v1
    public static function array_append( $array )
    {
        $a = $array;
        $arguments = func_num_args();

        for( $i = 1; $i < $arguments; $i++)
        {
            $a[] = func_get_arg($i);
        }
        return $a;
    }

    public static function array_prepend( $array )
    {
        $a = array(); 
        $arguments = func_num_args();

        for( $i = 1; $i < $arguments; $i++)
        {
            $a[] = func_get_arg($i);
        }

        return array_merge( $a, $array );
    }

    public static function array_swap( $array, $index1, $index2 )
    {
        $val = $array[$index1];
        $array[$index1] = $array[$index2];
        $array[$index2] = $val;

        unset( $val );
        return $array;
    }

    // array_find_replace( $a, $v, $vNew )::
    // $key = array_search( $v, $a ); if ( $key ) $a[$key] = $vNew;
    public static function array_find_replace( $array, $find, $replace )
    {
        $keys = array_keys( $array, $find ); 

        foreach( $keys as $key )
        {
            $array[$key] = $replace;
        }

        return $array;
    }

            //     array_extract_by_properties( $a, $pList )::
            // 
            //     array_sum( array_extract_by_properties( $order.items, array( 'price' ) ) )
            // 
            //     becomes
            // 
            //     foreach ( $order->items as $item )
            //     {
            //         $list[] = $item->price;
            //     }
            //     array_sum( $list )
            //     unset( $list )
    public static function array_extract_by_properties( $array, $properties )
    {
        $list = array();

        foreach( $array as $item )
        {
            foreach( $properties as $property )
            {
                $list[] = $item->$property;
            }
        }

        return $list;
    }
 
    public static function array_repeat( $array, $length )
    {
        $out = array(); 
        for( $i = 0; $i < $length; ++$i)
        {
            $out = array_merge( $out, $array );
        }

        return $out;
    }
  
    public static function array_sort( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        sort( $tmp, $flags );
        return $tmp;
    }

    public static function array_sort_reverse( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        rsort( $tmp, $flags );
        return $tmp;
    }

    public static function hash_sort( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        asort( $tmp, $flags );
        return $tmp;
    }

    public static function hash_sort_reverse( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        arsort( $tmp, $flags );
        return $tmp;
    }

    public static function hash_sort_keys( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        ksort( $tmp, $flags );
        return $tmp;
    }

    public static function hash_sort_keys_reverse( $array, $flags = SORT_REGULAR )
    {
        $tmp = $array;
        krsort( $tmp, $flags );
        return $tmp;
    }
}


?>
