<?php
/**
 * File containing the ezcTemplateFunctions class
 *
 * @package TemplateFunctions
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateArrayFunctions extends ezcTemplateFunctions
{
    public static function getFunctionSubstitution( $functionName )
    {
        switch( $functionName )
        {
            case "array_count": return array( array("%array" ), 
                    self::functionCall( "count", array( "%array" ) ) );



                /*
- *array* array_count( $a ) ( QList::count )::

    count( $a )

- *array* array_contains( $a, $v ) ( QList::contains )::

    in_array( $v, $a )

- *array* array_is_empty( $a ) ( QList::isEmpty() )::

    count( $a ) === 0

- *array* array_index_of( $a, $v, $index = 0 ) ( QList::indexOf() )::

    array_search( $v, $a )

- *array* array_index_exists( $a, $index ) ( QMap::find )::

    array_key_exists( $index, $a )

- *array* array_left( $a, $len )::

    array_slice( $a, 0, $len )

- *array* array_right( $a, $len )::

    array_slice( $a, 0, -$len )

- *array* array_mid( $a, $index, $len ) ( QValueList::mid )::

    array_slice( $a, $index, $len )

- *array* array_insert( $a, $index, $v1 [, $v2 ...] ) ( QList::insert() )::

    array_slice( $a, 0, $index ) + array( $v1 [, $v2 ...] ) + array_slice( $a, $index + value count )

- *array* array_append( $a, $v1 [, $v2 ...] ) ( QList::append() )::

    value count > 1 ? array_push( $a, $v1 [, $v2 ...] ) : $a[] = $v1

- *array* array_prepend( $a, $v1 [, $v2 ...] ) ( QList::prepend )::

    array_unshift( $a, $v1 [, $v2 ...] )

- *array* array_merge( $a1, $a2 [, $a3 ..] ) ( QList::+ )::

    array_merge( $a1, $a2 [, $a3 ...] )

- *array* array_remove( $a, $index, $len = 1 ) ( QList::remove )::

    array_slice( $a, 0, $index ) + array_slice( $a, $index + $len )

- *array* array_remove_first( $a ) ( QList::removeFirst() )::

    array_slice( $a, 1 )

- *array* array_remove_last( $a ) ( QList::removeLast() )::

    array_slice( $a, -1 )

- *array* array_first( $a ) ( QList::first )::

    count( $a ) > 0 ? $a[0] : false

- *array* array_last( $a ) ( QList::last )::

    count( $a ) > 0 ? $a[count( $a ) - 1] : false

- *array* array_replace( $a, $index, $len = 1, $v1 [, $v2 ...] ) ( QList::replace )::

    array_slice( $a, 0, $index ) + array( $v1 [, $v2 ...] ) + array_slice( $a, $index + $len )

- *array* array_swap( $a, $index1, $index2 ) ( QList::swap ) ?::

    $tmp1 = $a[$index1]; $a[$index1] = $a[$index2]; $a[$index2] = $tmp1; unset( $tmp1 );

- *array* array_at( $a, $index ) ( QList::at )::

    $a[$index]

- *array* array_reverse( $a )::

    array_reverse( $a )

- *array* array_diff( $a1, $a2 [, $a3 ...] )::

    array_diff( $a1, $a2 [, $a3 ...] )

- *array* array_insersect( $a1, $a2 [, $a3 ...] )::

    array_intersect( $a1, $a2 [, $a3 ...] )

- *array* array_pad( $a, $len, $fill )::

    array_pad( $a, $len, $fill )

- *array* array_unique( $a )::

    array_unique( $a )

- *array* array_find( $a, $v )::

    array_search( $v, $a )

- *array* array_find_replace( $a, $v, $vNew )::

    $key = array_search( $v, $a ); if ( $key ) $a[$key] = $vNew;

- *array* array_fill_range( $low, $high [, $step] )::

    array_range( $low, $high [, $step] )

- *array* array_sum( $a )::

    array_sum( $a )

- *array* array_extract_by_properties( $a, $pList )::

    array_sum( array_extract_by_properties( $order.items, array( 'price' ) ) )

    becomes

    foreach ( $order->items as $item )
    {
        $list[] = $item->price;
    }
    array_sum( $list )
    unset( $list )

- *array* array_extract_by_keys( $a, $kList )::

    array_sum( array_extract_by_keys( $order.items, array( 'price' ) ) )

    becomes

    foreach ( $order->items as $item )
    {
        $list[] = $item['price'];
    }
    array_sum( $list )
    unset( $list )


Working with associative arrays have some specialized functions

- *array* hash_diff( $a1, $a2 [, $a3 ...] )::

    array_diff_assoc( $a1, $a2 [, $a3 ...] )

- *array* hash_diff_key( $a1, $a2 [, $a3 ...] )::

    array_diff_key( $a1, $a2 [, $a3 ...] )

- *array* hash_intersect( $a1, $a2 [, $a3 ...] )::

    array_intersect_assoc( $a1, $a2 [, $a3 ...] )

- *array* hash_intersect_key( $a1, $a2 [, $a3 ...] )::

    array_intersect( $a1, $a2 [, $a3 ...] )

- *array* hash_keys( $a ) ( QMap::keys )::

    array_keys( $a )

- *array* hash_values( $a )::

    array_values( $a )

- *array* hash_flip( $a )::

    array_flip( $a )


Creating arrays can be done with:

- *array* array_fill( $v, $len ) ( QVector::fill )::

    array_fill( 0, $len, $v )

- *array* array_repeat( $asrc, $len ) ( QVector::fill )::

    $aout = array(); for ( $i = 0; $i < $len; ++$i ) { $aout += $a; }


Sorting of arrays is also possible, this will return the sorted array instead
of manipulating the input expression.

- *array* array_sort( $a [, $flag ] )::

    $tmpa = $a;
    sort( $a );
    return $tmpa;

- *array* array_sort_reverse( $a [, $flag ] )::

    $tmpa = $a;
    rsort( $a );
    return $tmpa;

- *array* hash_sort( $a [, $flag ] )::

    $tmpa = $a;
    asort( $a );
    return $tmpa;

- *array* hash_sort_reverse( $a [, $flag ] )::

    $tmpa = $a;
    arsort( $a );
    return $tmpa;


- *array* hash_sort_keys( $a [, $flag ] )::

    $tmpa = $a;
    ksort( $a );
    return $tmpa;

- *array* hash_sort_keys_reverse( $a [, $flag ] )::

    $tmpa = $a;
    krsort( $a );
    return $tmpa;

    */



            // str_replace( $sl, $index, $len, $sr )
            // substr( $sl, 0, $index ) . $sr . substr( $sl, $index + $len );
            }

        return null;
    }
}
