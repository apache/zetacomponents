<?php

return array (
  'REQUEST_METHOD' => 'MOVE',
  'REQUEST_URI' => '/collection/resource.html',
  'HTTP_DESTINATION' => '/other_collection/moved_resource.html',
  'HTTP_OVERWRITE' => 'F',
  'HTTP_IF' => '(<opaquelocktoken:1234>) (<opaquelocktoken:5678>)',
  'SERVER_PROTOCOL' => 'HTTP/1.1',
  'HTTP_HOST' => 'example.com',
  // foo : bar
  'HTTP_AUTHORIZATION' => 'Basic Zm9vOmJhcg==',
);

?>
