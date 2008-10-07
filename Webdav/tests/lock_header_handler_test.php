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
     * @dataProvider provideNoTagListData
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

    public function provideNoTagListData()
    {
        return array(
            // Set 1 - Not tagged
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
            // Set 2 - Not tagged, negated some
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
            // Set 3 - Tagged
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
            // Set 4 - Tagged, negated some
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
