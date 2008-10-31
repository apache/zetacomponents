<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
                            array( 'locktoken:a-write-lock-token' ),
                            array( 'A weak ETag' )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( 'strong ETag' )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( 'another strong ETag' )
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
                            array( 'opaquelocktoken:fe184f2e-6eec-41d0-c765-01adc56e6bb4' ),
                            array()
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array( 'opaquelocktoken:e454f3f3-acdc-452a-56c7-00a5c91e4b77' ),
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
                            array( 'locktoken:a-write-lock-token' ),
                            array( 'A weak ETag' ),
                            true
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( 'strong ETag' )
                        ),
                        new ezcWebdavLockIfHeaderListItem(
                            array(),
                            array( 'another strong ETag' ),
                            true
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
                                array( 'locktoken:a-write-lock-token' ),
                                array( 'A weak ETag' )
                            ),
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( 'strong ETag' )
                            ),
                        ),
                        '/random' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( 'another strong ETag' )
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
                                array( 'locktoken:a-write-lock-token' ),
                                array( 'A weak ETag' )
                            ),
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( 'strong ETag' ),
                                true
                            ),
                        ),
                        '/random' => array(
                            new ezcWebdavLockIfHeaderListItem(
                                array(),
                                array( 'another strong ETag' ),
                                true
                            ),
                        ),
                    )
                ),
            ),
        );
    }
}

?>
