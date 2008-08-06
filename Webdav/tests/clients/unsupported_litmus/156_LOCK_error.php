<?php

return array (
  0 => 
  ezcWebdavRequestNotSupportedException::__set_state(array(
     'originalMessage' => 'The request type \'ezcWebdavLockRequest\' is not supported by the transport. Backend could not dispatch request object.',
     'message' => 'The request type \'ezcWebdavLockRequest\' is not supported by the transport. Backend could not dispatch request object.',
     'string' => '',
     'code' => 0,
     'file' => '/home/dotxp/dev/ez/ezcomponents/trunk/Webdav/src/interfaces/backend.php',
     'line' => 158,
     'trace' => 
    array (
      0 => 
      array (
        'file' => '/home/dotxp/dev/ez/ezcomponents/trunk/Webdav/src/server.php',
        'line' => 126,
        'function' => 'performRequest',
        'class' => 'ezcWebdavBackend',
        'type' => '->',
        'args' => 
        array (
          0 => 
          ezcWebdavLockRequest::__set_state(array(
             'properties' => 
            array (
              'requestUri' => '/litmus/lockcoll',
              'lockInfo' => 
              ezcWebdavRequestLockInfoContent::__set_state(array(
                 'properties' => 
                array (
                  'lockScope' => 2,
                  'lockType' => 2,
                  'owner' => 'litmus test suite',
                ),
                 'pluginData' => 
                array (
                ),
              )),
            ),
             'headers' => 
            array (
              'Depth' => -1,
              'Timeout' => 'Second-3600',
            ),
             'validated' => true,
          )),
        ),
      ),
      1 => 
      array (
        'file' => '/home/dotxp/dev/ez/ezcomponents/trunk/Webdav/tests/scripts/test_generator.php',
        'line' => 193,
        'function' => 'handle',
        'class' => 'ezcWebdavServer',
        'type' => '->',
        'args' => 
        array (
          0 => 
          ezcWebdavMemoryBackend::__set_state(array(
             'options' => 
            ezcWebdavMemoryBackendOptions::__set_state(array(
               'properties' => 
              array (
                'failForRegexp' => NULL,
                'failingOperations' => 0,
              ),
            )),
             'content' => 
            array (
              '/' => 
              array (
                0 => '/collection',
                1 => '/file.xml',
                2 => '/file.bin',
                3 => '/litmus',
              ),
              '/collection' => 
              array (
                0 => '/collection/file.txt',
                1 => '/collection/subdir',
              ),
              '/collection/file.txt' => 'Some text content.',
              '/collection/subdir' => 
              array (
                0 => '/collection/subdir/file.html',
                1 => '/collection/subdir/file.xml',
              ),
              '/collection/subdir/file.html' => '<html><body><h1>Test</h1></body></html>',
              '/collection/subdir/file.xml' => '<?xml ?>
<content/>',
              '/file.xml' => '<?xml ?>
<content/>',
              '/file.bin' => '\000§"$%&',
              '/litmus' => 
              array (
                0 => '/litmus/lockme',
                1 => '/litmus/notlocked',
                2 => '/litmus/lockcoll',
              ),
              '/litmus/lockme' => 'This
is
a
test
file
called
foo

',
              '/litmus/notlocked' => 'This
is
a
test
file
called
foo

',
              '/litmus/lockcoll' => 
              array (
              ),
            ),
             'props' => 
            array (
              '/' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => '',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'httpd/unix-directory',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '6666cd76f96956469e7be39d750cc7d9',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '4096',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 2,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/collection' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'collection',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'httpd/unix-directory',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '9696c0fa460d4ed148cb40b2e8388c1e',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '4096',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 2,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/collection/file.txt' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'file.txt',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'text/plain',
                        'charset' => 'utf-8',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '60c0afeb8f68b1765e13694b5e7c8c3d',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '18',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/collection/subdir' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'subdir',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'httpd/unix-directory',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '2215ad4a0621fe1f07727e8534c54a95',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '4096',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 2,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/collection/subdir/file.html' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'file.html',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'text/html',
                        'charset' => 'utf-8',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '3b191a38c8e5d686506677906f3a4cfd',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '39',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/collection/subdir/file.xml' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'file.xml',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'text/xml',
                        'charset' => 'utf-8',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '8cc4e8038561985cf9e68ee3e36f8882',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '19',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/file.xml' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'file.xml',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'text/xml',
                        'charset' => 'utf-8',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => 'b0c5faef67f106ef634ad2a82e838b95',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '19',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/file.bin' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'file.bin',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'application/octet-stream',
                        'charset' => 'utf-8',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '68eab65ab82e7e474811d5d2dd879679',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '7',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/litmus' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'litmus',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'httpd/unix-directory',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => 'd5d6179894663c1220b1efc8bf8a06da',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '4096',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 2,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/litmus/lockme' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'lockme',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'application/octet-stream',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => '0f42e3f43ad7df0654c93aa4505499ba',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '0',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/litmus/notlocked' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'notlocked',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'application/octet-stream',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => 'b57e2a2223da0830795fecc2f27eea65',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '0',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 1,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
              '/litmus/lockcoll' => 
              ezcWebdavBasicPropertyStorage::__set_state(array(
                 'properties' => 
                array (
                  'DAV:' => 
                  array (
                    'creationdate' => 
                    ezcWebdavCreationDateProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'creationdate',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Tue, 27 May 2003 11:27:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'displayname' => 
                    ezcWebdavDisplayNameProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'displayname',
                        'displayName' => 'lockcoll',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlanguage' => 
                    ezcWebdavGetContentLanguageProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlanguage',
                        'languages' => 
                        array (
                          0 => 'en',
                        ),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontenttype' => 
                    ezcWebdavGetContentTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontenttype',
                        'mime' => 'httpd/unix-directory',
                        'charset' => NULL,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getetag' => 
                    ezcWebdavGetEtagProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getetag',
                        'etag' => 'cd79947fd133d02355446c1d261de7d1',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getlastmodified' => 
                    ezcWebdavGetLastModifiedProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getlastmodified',
                        'date' => 
                        ezcWebdavDateTime::__set_state(array(
                           'backupTime' => 'Mon, 15 Aug 2005 15:13:00 +0000',
                        )),
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'getcontentlength' => 
                    ezcWebdavGetContentLengthProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'getcontentlength',
                        'length' => '4096',
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                    'resourcetype' => 
                    ezcWebdavResourceTypeProperty::__set_state(array(
                       'properties' => 
                      array (
                        'hasError' => false,
                        'errors' => 
                        array (
                        ),
                        'namespace' => 'DAV:',
                        'name' => 'resourcetype',
                        'type' => 2,
                      ),
                       'pluginData' => 
                      array (
                      ),
                    )),
                  ),
                ),
                 'propertyOrder' => 
                array (
                  0 => 
                  array (
                    0 => 'DAV:',
                    1 => 'creationdate',
                  ),
                  1 => 
                  array (
                    0 => 'DAV:',
                    1 => 'displayname',
                  ),
                  2 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlanguage',
                  ),
                  3 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontenttype',
                  ),
                  4 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getetag',
                  ),
                  5 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getlastmodified',
                  ),
                  6 => 
                  array (
                    0 => 'DAV:',
                    1 => 'getcontentlength',
                  ),
                  7 => 
                  array (
                    0 => 'DAV:',
                    1 => 'resourcetype',
                  ),
                ),
                 'propertyOrderPosition' => 0,
                 'propertyOrderNextId' => 8,
              )),
            ),
             'fakeLiveProperties' => true,
          )),
        ),
      ),
      2 => 
      array (
        'file' => '/home/dotxp/web/webdav/htdocs/index.php',
        'line' => 14,
        'function' => 'run',
        'class' => 'ezcWebdavClientTestGenerator',
        'type' => '->',
        'args' => 
        array (
        ),
      ),
    ),
  )),
);

?>