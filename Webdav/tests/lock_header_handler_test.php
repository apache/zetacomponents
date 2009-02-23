<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavFileBackendOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockHeaderHandlerTest extends ezcWebdavTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        ezcWebdavServer::getInstance()->init(
            new ezcWebdavBasicPathFactory( 'http://example.com' ),
            new ezcWebdavXmlTool(),
            new ezcWebdavPropertyHandler(),
            new ezcWebdavHeaderHandler(),
            new ezcWebdavTransport()
        );
    }

    protected function tearDown()
    {
        ezcWebdavServer::getInstance()->reset();
    }
    
    /**
     * testParseNoTaggedList 
     * 
     * @param mixed $content 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideIfHeaderData
     */
    public function testParseIfHeader( $content, $result )
    {
        $_SERVER['HTTP_IF'] = $content;
        
        $handler = new ezcWebdavLockHeaderHandler();
        
        $this->assertEquals(
            $result,
            $handler->parseIfHeader()
        );
    }

    /**
     * testParseTimeoutHeader 
     * 
     * @param mixed $content 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideTimeoutHeaderData
     */
    public function testParseTimeoutHeader( $content, $result )
    {
        $_SERVER['HTTP_TIMEOUT'] = $content;
        
        $handler = new ezcWebdavLockHeaderHandler();
        
        $this->assertEquals(
            $result,
            $handler->parseTimeoutHeader()
        );
    }

    public function provideTimeoutHeaderData()
    {
        return array(
            // Set 1 - Ususally expected
            array(
                'Second-23',
                array( 23 )
            ),
            // Set 2 - Also expected
            array(
                'Infinite, Second-23',
                array( 23 )
            ),
            // Set 3 - May occur
            array(
                'Infinite, Second-123456789, Second-23',
                array( 123456789, 23 )
            ),
        );
    }

    public function provideIfHeaderData()
    {
        return array(
            // Not tagged
            array( 
                '(<locktoken:a-write-lock-token> [W/"A weak ETag"]) (["strong ETag"]) (["another strong ETag"])',
                new ezcWebdavLockIfHeaderNoTagList(
                    array(
                        new ezcWebdavLockIfHeaderListItem(
                            array( new ezcWebdavLockIfHeaderCondition( 'locktoken:a-write-lock-token' ) ),
                            array( new ezcWebdavLockIfHeaderCondition( 'A weak ETag' ) )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( new ezcWebdavLockIfHeaderCondition( 'strong ETag' ) )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( new ezcWebdavLockIfHeaderCondition( 'another strong ETag' ) )
                        ),
                    )
                ),
            ),
            // Not tagged, mutiple lock tokens, from RFC
            array(
                '(<opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4>)  (<opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77>)',
                new ezcWebdavLockIfHeaderNoTagList(
                    array(
                        new ezcWebdavLockIfHeaderListItem(
                            array( new ezcWebdavLockIfHeaderCondition( 'opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4' ) ),
                            array()
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array( new ezcWebdavLockIfHeaderCondition( 'opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77' ) ),
                            array()
                        ),
                    )
                ),
            ),
            // Not tagged, negated some
            array( 
                '(Not <locktoken:a-write-lock-token> [W/"A weak ETag"]) (["strong ETag"]) (Not ["another strong ETag"])',
                new ezcWebdavLockIfHeaderNoTagList(
                    array(
                        new ezcWebdavLockIfHeaderListItem(
                            array( new ezcWebdavLockIfHeaderCondition( 'locktoken:a-write-lock-token', true ) ),
                            array( new ezcWebdavLockIfHeaderCondition( 'A weak ETag' ) )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( new ezcWebdavLockIfHeaderCondition( 'strong ETag' ) )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( new ezcWebdavLockIfHeaderCondition( 'another strong ETag', true ) )
                        ),
                    )
                ),
            ),
            // Not tagged, lock token and etag, from Litmus
            array( 
                '(<opaquelocktoken:43e241e1-df33-d3ee-bbfc-c613148efeb0> [fdf78d927cbf3fac5929db44c91d5783])',
                new ezcWebdavLockIfHeaderNoTagList(
                    array(
                        new ezcWebdavLockIfHeaderListItem(
                            array( new ezcWebdavLockIfHeaderCondition( 'opaquelocktoken:43e241e1-df33-d3ee-bbfc-c613148efeb0' ) ),
                            array( new ezcWebdavLockIfHeaderCondition( 'fdf78d927cbf3fac5929db44c91d5783' ) )
                        ),
                    )
                ),
            ),
            // Tagged
            array( 
                '<http://example.com/resource1> (<locktoken:a-write-lock-token> [W/"A weak ETag"]) (["strong ETag"]) <http://example.com/random> (["another strong ETag"])',
                new ezcWebdavLockIfHeaderTaggedList(
                    array(
                        '/resource1' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array( new ezcWebdavLockIfHeaderCondition( 'locktoken:a-write-lock-token' ) ),
                                array( new ezcWebdavLockIfHeaderCondition( 'A weak ETag' ) )
                            ),
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( new ezcWebdavLockIfHeaderCondition( 'strong ETag' ) )
                            ),
                        ),
                        '/random' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( new ezcWebdavLockIfHeaderCondition( 'another strong ETag' ) )
                            ),
                        ),
                    )
                ),
            ),
            // Tagged, negated some
            array( 
                '<http://example.com/resource1> (<locktoken:a-write-lock-token> [W/"A weak ETag"]) (Not ["strong ETag"]) <http://example.com/random> (Not ["another strong ETag"])',
                new ezcWebdavLockIfHeaderTaggedList(
                    array(
                        '/resource1' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array( new ezcWebdavLockIfHeaderCondition( 'locktoken:a-write-lock-token' ) ),
                                array( new ezcWebdavLockIfHeaderCondition( 'A weak ETag' ) )
                            ),
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( new ezcWebdavLockIfHeaderCondition( 'strong ETag', true ) ),
                                true
                            ),
                        ),
                        '/random' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( new ezcWebdavLockIfHeaderCondition( 'another strong ETag', true ) )
                            ),
                        ),
                    )
                ),
            ),
            array(
                '<http://webdav/collection/newdir/> (<opaquelocktoken:e0491761-ef66-9c09-94be-b43d185e2ad3>) <http://webdav/collection/subdir/> (<opaquelocktoken:2e5dba96-db89-da63-e87e-f9688848a315>)',
                new ezcWebdavLockIfHeaderTaggedList(
                    array(
                        '/collection/newdir' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array( new ezcWebdavLockIfHeaderCondition( 'opaquelocktoken:e0491761-ef66-9c09-94be-b43d185e2ad3' ) )
                            ),
                        ),
                        '/collection/subdir' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array( new ezcWebdavLockIfHeaderCondition( 'opaquelocktoken:2e5dba96-db89-da63-e87e-f9688848a315' ) )
                            ),
                        ),
                    )
                ),
            ),
        );
    }
}

?>
