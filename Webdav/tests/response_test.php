<?php
/**
 * Basic test cases for the response class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'request_test.php';

/**
 * Tests for ezcWebdavBasicPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavResponseTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavMultistatusResponse';
        $this->defaultValues = array(
            'responseDescription' => null,
        );
        $this->workingValues = array(
            'responseDescription' => array(
                'This is nice response!',
            ),
        );
        $this->failingValues = array(
            'responseDescription' => array( 
                42,
                true,
            ),
        );
    }

    public function testMultistatusResponseSingle()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 )
        );

        $this->assertEquals(
            $response->responses,
            array( $error ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultiple()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
            $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultipleFlatten()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
            array(
                $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 ),
            )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultipleOnlyFlatten()
    {
        $response = new ezcWebdavMultistatusResponse(
            array(
                $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
                $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 ),
            )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }
}

?>
