<?php
/**
 * Autoloader definition for the Webdav component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Webdav
 */

return array(
    'ezcWebdavException'                    => 'Webdav/exceptions/exception.php',
    'ezcWebdavNotTransportHandlerException' => 'Webdav/exceptions/no_transport_handler.php',
    'ezcWebdavBackend'                      => 'Webdav/interfaces/backend.php',
    'ezcWebdavBackendChange'                => 'Webdav/interfaces/backend/change.php',
    'ezcWebdavBackendMakeCollection'        => 'Webdav/interfaces/backend/make_collection.php',
    'ezcWebdavBackendPut'                   => 'Webdav/interfaces/backend/put.php',
    'ezcWebdavFileBackend'                  => 'Webdav/backend/file.php',
    'ezcWebdavGetRequest'                   => 'Webdav/request/get.php',
    'ezcWebdavPathFactory'                  => 'Webdav/path_factory.php',
    'ezcWebdavRequest'                      => 'Webdav/request.php',
    'ezcWebdavResponse'                     => 'Webdav/response.php',
    'ezcWebdavServer'                       => 'Webdav/server.php',
    'ezcWebdavTransport'                    => 'Webdav/transport.php',
    'ezcWebdavXmlBase'                      => 'Webdav/interfaces/xml_base.php',
);
?>
