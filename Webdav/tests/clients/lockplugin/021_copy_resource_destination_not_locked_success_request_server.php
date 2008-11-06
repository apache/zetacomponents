<?php

return array (
  'REQUEST_METHOD' => 'COPY',
  'REQUEST_URI' => '/collection/resource.html',
  'HTTP_DESTINATION' => '/other_collection/moved_resource.html',
  'HTTP_OVERWRITE' => 'F',
  'HTTP_IF' => '<http://example.com/collection/resource.html> (<opaquelocktoken:1234>)',
  'SERVER_PROTOCOL' => 'HTTP/1.1',
  'HTTP_HOST' => 'example.com',
  // foo : bar
  'HTTP_AUTHORIZATION' => 'Basic Zm9vOmJhcg==',
);

?>
