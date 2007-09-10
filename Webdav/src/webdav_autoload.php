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
    'ezcWebdavProperty'                        => 'Webdav/interfaces/property.php',
    'ezcWebdavBackend'                         => 'Webdav/interfaces/backend.php',
    'ezcWebdavBackendChange'                   => 'Webdav/interfaces/backend/change.php',
    'ezcWebdavBackendMakeCollection'           => 'Webdav/interfaces/backend/make_collection.php',
    'ezcWebdavBackendPut'                      => 'Webdav/interfaces/backend/put.php',
    'ezcWebdavSupportedlockPropertyLockentry'  => 'Webdav/properties/supportedlock_lockentry.php',
    'ezcWebdavCreationdateProperty'            => 'Webdav/properties/creationdate.php',
    'ezcWebdavDisplaynameProperty'             => 'Webdav/properties/displayname.php',
    'ezcWebdavFileBackend'                     => 'Webdav/backend/file.php',
    'ezcWebdavGetRequest'                      => 'Webdav/request/get.php',
    'ezcWebdavGetcontentlanguageProperty'      => 'Webdav/properties/getcontentlanguage.php',
    'ezcWebdavGetcontentlengthProperty'        => 'Webdav/properties/getcontentlength.php',
    'ezcWebdavGetcontenttypeProperty'          => 'Webdav/properties/getcontenttype.php',
    'ezcWebdavGeteetagProperty'                => 'Webdav/properties/getetag.php',
    'ezcWebdavGetlastmodifiedProperty'         => 'Webdav/properties/getlastmodified.php',
    'ezcWebdavLockdiscoveryProperty'           => 'Webdav/properties/lockdiscovery.php',
    'ezcWebdavLockdiscoveryPropertyActivelock' => 'Webdav/properties/lockdiscovery_activelock.php',
    'ezcWebdavPathFactory'                     => 'Webdav/path_factory.php',
    'ezcWebdavRequest'                         => 'Webdav/request.php',
    'ezcWebdavResourcetypeProperty'            => 'Webdav/properties/resourcetype.php',
    'ezcWebdavResponse'                        => 'Webdav/response.php',
    'ezcWebdavServer'                          => 'Webdav/server.php',
    'ezcWebdavServerOptions'                   => 'Webdav/options/server.php',
    'ezcWebdavSourceProperty'                  => 'Webdav/properties/source.php',
    'ezcWebdavSourcePropertyLink'              => 'Webdav/properties/source_link.php',
    'ezcWebdavSupportedlockProperty'           => 'Webdav/properties/supportedlock.php',
    'ezcWebdavTransport'                       => 'Webdav/transport.php',
    'ezcWebdavXmlBase'                         => 'Webdav/interfaces/xml_base.php',
);
?>
