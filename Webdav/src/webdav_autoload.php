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
    'ezcWebdavException'                       => 'Webdav/exceptions/exception.php',
    'ezcWebdavBrokenRequestUriException'       => 'Webdav/exceptions/broken_request_uri.php',
    'ezcWebdavMissingServerVariableException'  => 'Webdav/exceptions/misssing_server_variable.php',
    'ezcWebdavNotTransportHandlerException'    => 'Webdav/exceptions/no_transport_handler.php',
    'ezcWebdavXmlBase'                         => 'Webdav/interfaces/xml_base.php',
    'ezcWebdavProperty'                        => 'Webdav/interfaces/property.php',
    'ezcWebdavBackend'                         => 'Webdav/interfaces/backend.php',
    'ezcWebdavBackendChange'                   => 'Webdav/interfaces/backend/change.php',
    'ezcWebdavBackendMakeCollection'           => 'Webdav/interfaces/backend/make_collection.php',
    'ezcWebdavBackendPut'                      => 'Webdav/interfaces/backend/put.php',
    'ezcWebdavSupportedLockPropertyLockentry'  => 'Webdav/properties/supportedlock_lockentry.php',
    'ezcWebdavCreationDateProperty'            => 'Webdav/properties/creationdate.php',
    'ezcWebdavDisplayNameProperty'             => 'Webdav/properties/displayname.php',
    'ezcWebdavFileBackend'                     => 'Webdav/backend/file.php',
    'ezcWebdavGetContentLanguageProperty'      => 'Webdav/properties/getcontentlanguage.php',
    'ezcWebdavGetContentLengthProperty'        => 'Webdav/properties/getcontentlength.php',
    'ezcWebdavGetContentTypeProperty'          => 'Webdav/properties/getcontenttype.php',
    'ezcWebdavGetEtagProperty'                 => 'Webdav/properties/getetag.php',
    'ezcWebdavGetLastModifiedProperty'         => 'Webdav/properties/getlastmodified.php',
    'ezcWebdavGetRequest'                      => 'Webdav/request/get.php',
    'ezcWebdavLockDiscoveryProperty'           => 'Webdav/properties/lockdiscovery.php',
    'ezcWebdavLockDiscoveryPropertyActiveLock' => 'Webdav/properties/lockdiscovery_activelock.php',
    'ezcWebdavMemoryBackend'                   => 'Webdav/backend/memory.php',
    'ezcWebdavMemoryBackendOptions'            => 'Webdav/options/backend_memory_options.php',
    'ezcWebdavPathFactory'                     => 'Webdav/path_factory.php',
    'ezcWebdavRequest'                         => 'Webdav/request.php',
    'ezcWebdavResourceTypeProperty'            => 'Webdav/properties/resourcetype.php',
    'ezcWebdavResponse'                        => 'Webdav/response.php',
    'ezcWebdavServer'                          => 'Webdav/server.php',
    'ezcWebdavServerOptions'                   => 'Webdav/options/server.php',
    'ezcWebdavSourceProperty'                  => 'Webdav/properties/source.php',
    'ezcWebdavSourcePropertyLink'              => 'Webdav/properties/source_link.php',
    'ezcWebdavSupportedLockProperty'           => 'Webdav/properties/supportedlock.php',
    'ezcWebdavTransport'                       => 'Webdav/transport.php',
);
?>
