<?php
return array (
  'headers' => 
  array (
    0 => 'HTTP/1.1 204 No Content',
    1 => 'HTTP/1.1 207 Multi-Status',
    2 => 'HTTP/1.1 412 Precondition Failed',
    3 => 'HTTP/1.1 204 No Content',
    4 => 'HTTP/1.1 423 Locked',
    5 => 'HTTP/1.1 207 Multi-Status',
    6 => 'HTTP/1.1 207 Multi-Status',
  ),
  'body' => '<?xml version="1.0" encoding="UTF-8"?>
<D:multistatus xmlns:D="DAV:"><D:response><D:href>http://foo.bar/container</D:href><D:status>HTTP/1.1 423 Locked</D:status></D:response><D:response><D:href>http://foo.bar/container/front.html</D:href><D:status>HTTP/1.1 423 Locked</D:status></D:response><D:response><D:href>http://foo.bar/container/R2</D:href><D:status>HTTP/1.1 423 Locked</D:status></D:response><D:response><D:href>http://foo.bar/container/resource3</D:href><D:status>HTTP/1.1 423 Locked</D:status></D:response></D:multistatus>
',
);
?>