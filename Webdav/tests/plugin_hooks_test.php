<?php

libxml_use_internal_errors( true );

/**
 * Reqiuire base test
 */

/**
 * Tests for ezcWebdavTransport class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavPluginTest
{
    protected $hooks;

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function __construct()
    {
        $this->hooks = array (
            'ezcWebdavTransport' => array (
                'beforeParseCopyRequest'              => true,
                'afterParseCopyRequest'               => true,
                'beforeParseDeleteRequest'            => true,
                'afterParseDeleteRequest'             => true,
                'beforeParseGetRequest'               => true,
                'afterParseGetRequest'                => true,
                'beforeParseHeadRequest'              => true,
                'afterParseHeadRequest'               => true,
                'beforeParseMakeCollectionRequest'    => true,
                'afterParseMakeCollectionRequest'     => true,
                'beforeParseMoveRequest'              => true,
                'afterParseMoveRequest'               => true,
                'beforeParseOptionsRequest'           => true,
                'afterParseOptionsRequest'            => true,
                'beforeParsePropFindRequest'          => true,
                'afterParsePropFindRequest'           => true,
                'beforeParsePropPatchRequest'         => true,
                'afterParsePropPatchRequest'          => true,
                'beforeParsePutRequest'               => true,
                'afterParsePutRequest'                => true,
                'beforeProcessCopyResponse'           => true,
                'afterProcessCopyResponse'            => true,
                'beforeProcessDeleteResponse'         => true,
                'afterProcessDeleteResponse'          => true,
                'beforeProcessErrorResponse'          => true,
                'afterProcessErrorResponse'           => true,
                'beforeProcessGetCollectionResponse'  => true,
                'afterProcessGetCollectionResponse'   => true,
                'beforeProcessGetResourceResponse'    => true,
                'afterProcessGetResourceResponse'     => true,
                'beforeProcessHeadResponse'           => true,
                'afterProcessHeadResponse'            => true,
                'beforeProcessMakeCollectionResponse' => true,
                'afterProcessMakeCollectionResponse'  => true,
                'beforeProcessMoveResponse'           => true,
                'afterProcessMoveResponse'            => true,
                'beforeProcessMultiStatusResponse'    => true,
                'afterProcessMultiStatusResponse'     => true,
                'beforeProcessOptionsResponse'        => true,
                'afterProcessOptionsResponse'         => true,
                'beforeProcessPropFindResponse'       => true,
                'afterProcessPropFindResponse'        => true,
                'beforeProcessPropPatchResponse'      => true,
                'afterProcessPropPatchResponse'       => true,
                'beforeProcessPutResponse'            => true,
                'afterProcessPutResponse'             => true,
                'parseUnknownRequest'                 => true,
                'handleUnknownResponse'               => true,
                'beforeExtractLiveProperty'           => true,
                'afterExtractLiveProperty'            => true,
                'beforeExtractDeadProperty'           => true,
                'afterExtractDeadProperty'            => true,
                'beforeSerializeLiveProperty'         => true,
                'afterSerializeLiveProperty'          => true,
                'beforeSerializeDeadProperty'         => true,
                'afterSerializeDeadProperty'          => true,
                'extractUnknownLiveProperty'          => true,
                'serializeUnknownLiveProperty'        => true,
            ),
            'ezcWebdavServer' => array (
                'receivedRequest'   => true,
                'generatedResponse' => true,
            ),
        );
    }

    public function __call( $method, $parameters )
    {
        if ( strpos( $method, 'ezcWebdavTransport' ) === 0 )
        {

        }
        else
        {

        }
    }
}

?>
