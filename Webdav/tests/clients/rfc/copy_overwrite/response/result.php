<?php
return array (
  'headers' => 
  array (
    0 => 'HTTP/1.1 204 No Content',
    1 => 'HTTP/1.1 207 Multi-Status',
    2 => 'HTTP/1.1 412 Precondition Failed',
  ),
  'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:response xmlns:D="DAV:"><D:href>http://foo.bar/users/f/fielding/index.html</D:href><D:status>HTTP/1.1 412 Precondition Failed</D:status></D:response>
',
);
?>