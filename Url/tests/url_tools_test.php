<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlToolsTest extends ezcTestCase
{
    protected static $queriesParseStr = array( // original URL, parse result, http_build_query() result

        array( '',                              array(),                                                     '' ),
        array( 'foo',                           array( 'foo'    => null ),                                    'foo=' ),

        array( 'foo=bar',                       array( 'foo'    => 'bar' ),                                   'foo=bar' ),
        array( 'foo[]=bar',                     array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[][]=bar',                   array( 'foo'    => array( array( 'bar' ) ) ),                 'foo[0][0]=bar' ),
        array( 'foo[][][]=bar',                 array( 'foo'    => array( array( array( 'bar' ) ) ) ),        'foo[0][0][0]=bar' ),

        array( 'foo[][]=bar&foo=baz',           array( 'foo'    => 'baz' ),                                   'foo=baz' ),
        array( 'foo[][]=bar&foo[]=baz',         array( 'foo'    => array( array( 'bar' ), 'baz' ) ),          'foo[0][0]=bar&foo[1]=baz' ),
        array( 'foo[]=bar&foo[][]=baz',         array( 'foo'    => array( 'bar', array( 'baz' ) ) ),          'foo[0]=bar&foo[1][0]=baz' ),
        array( 'foo[][]=bar&foo[][]=baz',       array( 'foo'    => array( array( 'bar' ), array( 'baz' ) ) ), 'foo[0][0]=bar&foo[1][0]=baz' ),
        array( 'foo=bar&answer=42',             array( 'foo'    => 'bar', 'answer' => '42' ),                 'foo=bar&answer=42' ),
        array( 'foo[]=bar&answer=42',           array( 'foo'    => array( 'bar' ), 'answer' => '42' ),        'foo[0]=bar&answer=42' ),
        array( 'foo[]=bar&answer=42&foo[]=baz', array( 'foo'    => array( 'bar', 'baz' ), 'answer' => '42' ), 'foo[0]=bar&foo[1]=baz&answer=42' ),

        array( 'foo=bar&amp;answer=42',         array( 'foo'    => 'bar', 'amp;answer' => '42' ),             'foo=bar&amp;answer=42' ),

        array( 'foo[0]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[1]=bar',                    array( 'foo'    => array( 1 => 'bar' ) ),                     'foo[1]=bar' ),
        array( 'foo[0]=bar&foo[0]=baz',         array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),
        array( 'foo[0][0]=bar&foo[0]=baz',      array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),

        array( 'foo=ba+r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba%20r',                    array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba.r',                      array( 'foo'    => 'ba.r' ),                                  'foo=ba.r' ),

        array( 'fo.o=bar',                      array( 'fo_o'   => 'bar' ),                                   'fo_o=bar' ),
        array( 'fo.o[]=bar',                    array( 'fo_o'   => array( 'bar' ) ),                          'fo_o[0]=bar' ),
        array( 'fo:o=bar',                      array( 'fo:o'   => 'bar' ),                                   'fo:o=bar' ),
        array( 'fo;o=bar',                      array( 'fo;o'   => 'bar' ),                                   'fo;o=bar' ),
        array( 'foo()=bar',                     array( 'foo()'  => 'bar' ),                                   'foo()=bar' ),
        array( 'foo{}=bar',                     array( 'foo{}'  => 'bar' ),                                   'foo{}=bar' ),

        array( 'fo.o=bar&answer=42',            array( 'fo_o'   => 'bar', 'answer' => 42 ),                   'fo_o=bar&answer=42' ),

        array( 'foo[=bar',                      array( 'foo_'   => 'bar' ),                                   'foo_=bar' ),
        array( 'foo[[=bar',                     array( 'foo_['  => 'bar' ),                                   'foo_[=bar' ),
        array( 'foo]=bar',                      array( 'foo]'   => 'bar' ),                                   'foo]=bar' ),
        array( 'foo]]=bar',                     array( 'foo]]'  => 'bar' ),                                   'foo]]=bar' ),
        array( 'foo][=bar',                     array( 'foo]_'  => 'bar' ),                                   'foo]_=bar' ),
        array( 'foo[[]=bar',                    array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]=bar',                    array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo][[=bar',                    array( 'foo]_[' => 'bar' ),                                   'foo]_[=bar' ),

        array( 'fo[o=bar',                      array( 'fo_o'   => 'bar' ),                                   'fo_o=bar' ),
        array( 'fo[[o=bar',                     array( 'fo_[o'  => 'bar' ),                                   'fo_[o=bar' ),
        array( 'fo]o=bar',                      array( 'fo]o'   => 'bar' ),                                   'fo]o=bar' ),
        array( 'fo]]o=bar',                     array( 'fo]]o'  => 'bar' ),                                   'fo]]o=bar' ),
        array( 'fo][o=bar',                     array( 'fo]_o'  => 'bar' ),                                   'fo]_o=bar' ),
        array( 'foo[[]o=bar',                   array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]o=bar',                   array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[]o=bar',                     array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        array( 'fo][[o=bar',                    array( 'fo]_[o' => 'bar' ),                                   'fo]_[o=bar' ),

        array( 'foo[[0]o=bar',                  array( 'foo'    => array( '[0' => 'bar' ) ),                  'foo[[0]=bar' ),
        array( 'foo][0]o=bar',                  array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[0][o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[0]]o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[0]o=bar',                    array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        );

    protected static $queriesParseQueryString = array( // original URL, parse result, http_build_query() result

        array( '',                              array(),                                                     '' ),
        array( 'foo',                           array( 'foo'    => null ),                                    'foo=' ),

        array( 'foo=bar',                       array( 'foo'    => 'bar' ),                                   'foo=bar' ),
        array( 'foo[]=bar',                     array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[][]=bar',                   array( 'foo'    => array( array( 'bar' ) ) ),                 'foo[0][0]=bar' ),
        array( 'foo[][][]=bar',                 array( 'foo'    => array( array( array( 'bar' ) ) ) ),        'foo[0][0][0]=bar' ),

        array( 'foo[][]=bar&foo=baz',           array( 'foo'    => 'baz' ),                                   'foo=baz' ),
        array( 'foo[][]=bar&foo[]=baz',         array( 'foo'    => array( array( 'bar' ), 'baz' ) ),          'foo[0][0]=bar&foo[1]=baz' ),
        array( 'foo[]=bar&foo[][]=baz',         array( 'foo'    => array( 'bar', array( 'baz' ) ) ),          'foo[0]=bar&foo[1][0]=baz' ),
        array( 'foo[][]=bar&foo[][]=baz',       array( 'foo'    => array( array( 'bar' ), array( 'baz' ) ) ), 'foo[0][0]=bar&foo[1][0]=baz' ),
        array( 'foo=bar&answer=42',             array( 'foo'    => 'bar', 'answer' => '42' ),                 'foo=bar&answer=42' ),
        array( 'foo[]=bar&answer=42',           array( 'foo'    => array( 'bar' ), 'answer' => '42' ),        'foo[0]=bar&answer=42' ),
        array( 'foo[]=bar&answer=42&foo[]=baz', array( 'foo'    => array( 'bar', 'baz' ), 'answer' => '42' ), 'foo[0]=bar&foo[1]=baz&answer=42' ),

        array( 'foo=bar&amp;answer=42',         array( 'foo'    => 'bar', 'amp;answer' => '42' ),             'foo=bar&amp;answer=42' ),

        array( 'foo[0]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[1]=bar',                    array( 'foo'    => array( 1 => 'bar' ) ),                     'foo[1]=bar' ),
        array( 'foo[0]=bar&foo[0]=baz',         array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),
        array( 'foo[0][0]=bar&foo[0]=baz',      array( 'foo'    => array( 'baz' ) ),                          'foo[0]=baz' ),

        array( 'foo=ba+r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba%20r',                    array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba r',                      array( 'foo'    => 'ba r' ),                                  'foo=ba r' ),
        array( 'foo=ba.r',                      array( 'foo'    => 'ba.r' ),                                  'foo=ba.r' ),

        array( 'fo.o=bar',                      array( 'fo.o'   => 'bar' ),                                   'fo.o=bar' ),
        array( 'fo.o[]=bar',                    array( 'fo.o'   => array( 'bar' ) ),                          'fo.o[0]=bar' ),
        array( 'fo:o=bar',                      array( 'fo:o'   => 'bar' ),                                   'fo:o=bar' ),
        array( 'fo;o=bar',                      array( 'fo;o'   => 'bar' ),                                   'fo;o=bar' ),
        array( 'foo()=bar',                     array( 'foo()'  => 'bar' ),                                   'foo()=bar' ),
        array( 'foo{}=bar',                     array( 'foo{}'  => 'bar' ),                                   'foo{}=bar' ),

        array( 'fo.o=bar&answer=42',            array( 'fo.o'   => 'bar', 'answer' => 42 ),                   'fo.o=bar&answer=42' ),

        array( 'foo[=bar',                      array( 'foo_'   => 'bar' ),                                   'foo_=bar' ),
        array( 'foo[[=bar',                     array( 'foo_['  => 'bar' ),                                   'foo_[=bar' ),
        array( 'foo]=bar',                      array( 'foo]'   => 'bar' ),                                   'foo]=bar' ),
        array( 'foo]]=bar',                     array( 'foo]]'  => 'bar' ),                                   'foo]]=bar' ),
        array( 'foo][=bar',                     array( 'foo]_'  => 'bar' ),                                   'foo]_=bar' ),
        array( 'foo[[]=bar',                    array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]=bar',                    array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]=bar',                    array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo][[=bar',                    array( 'foo]_[' => 'bar' ),                                   'foo]_[=bar' ),

        array( 'fo[o=bar',                      array( 'fo_o'   => 'bar' ),                                   'fo_o=bar' ),
        array( 'fo[[o=bar',                     array( 'fo_[o'  => 'bar' ),                                   'fo_[o=bar' ),
        array( 'fo]o=bar',                      array( 'fo]o'   => 'bar' ),                                   'fo]o=bar' ),
        array( 'fo]]o=bar',                     array( 'fo]]o'  => 'bar' ),                                   'fo]]o=bar' ),
        array( 'fo][o=bar',                     array( 'fo]_o'  => 'bar' ),                                   'fo]_o=bar' ),
        array( 'foo[[]o=bar',                   array( 'foo'    => array( '[' => 'bar' ) ),                   'foo[[]=bar' ),
        array( 'foo][]o=bar',                   array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[][o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[]]o=bar',                   array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[]o=bar',                     array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        array( 'fo][[o=bar',                    array( 'fo]_[o' => 'bar' ),                                   'fo]_[o=bar' ),

        array( 'foo[[0]o=bar',                  array( 'foo'    => array( '[0' => 'bar' ) ),                  'foo[[0]=bar' ),
        array( 'foo][0]o=bar',                  array( 'foo]'   => array( 'bar' ) ),                          'foo][0]=bar' ),
        array( 'foo[0][o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'foo[0]]o=bar',                  array( 'foo'    => array( 'bar' ) ),                          'foo[0]=bar' ),
        array( 'fo[0]o=bar',                    array( 'fo'     => array( 'bar' ) ),                          'fo[0]=bar' ),
        );

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testParseStr()
    {
        foreach ( self::$queriesParseStr as $query )
        {
            parse_str( $query[0], $params );

            $this->assertEquals( $query[1], $params, "Failed parsing '{$query[0]}'" );
            $this->assertEquals( $query[2], urldecode( http_build_query( $params ) ), "Failed building back the query '{$query[0]}' to '{$query[2]}'" );
        }
    }

    public function testParseQueryString()
    {
        foreach ( self::$queriesParseQueryString as $query )
        {
            $params = ezcUrlTools::parseQueryString( $query[0] );

            $this->assertEquals( $query[1], $params, "Failed parsing '{$query[0]}'" );
            $this->assertEquals( $query[2], urldecode( http_build_query( $params ) ), "Failed building back the query '{$query[0]}' to '{$query[2]}'" );
        }
    }
}
?>
