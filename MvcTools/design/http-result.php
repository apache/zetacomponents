<?php
$result = new ezcMvcResult;

$result->status = ezcMvcResult::OK;
// = HTTP/1.x 200 OK

$result->date = new DateTime( 'Tue, 08 Jul 2008 09:12:03 GMT' );
// = Date: Tue, 08 Jul 2008 09:12:03 GMT

$result->generator = 'Apache/1.3.37 ( Unix) mod_gzip/1.3.26.1a PHP/4.4.4 mod_ssl/2.8.28 OpenSSL/0.9.8c';
// = Server: Apache/1.3.37 ( Unix) mod_gzip/1.3.26.1a PHP/4.4.4 mod_ssl/2.8.28 OpenSSL/0.9.8c

$result->raw = new ezcMvcRawResult;

$result->raw->headers['X-Powered-By'] = 'eZ Publish';
// = X-Powered-By: eZ publish

$result->cache = new ezcMvcCacheResult;

$result->cache->vary = '*';
// = Vary: *

$result->cache->expire = new DateTime( 'Mon, 26 Jul 1997 05:00:00 GMT' );
// = Expires: Mon, 26 Jul 1997 05:00:00 GMT

$result->cache->controls = array( 'no-cache', 'must-validate' );
// = Cache-Control: no-cache, must-revalidate

$result->cache->pragma = 'no-cache';
// = Pragma: no-cache

$result->cache->lastModified = new DateTime( 'Tue, 08 Jul 2008 09:12:03 GMT' );
// = Last-Modified: Tue, 08 Jul 2008 09:12:03 GMT

$cookie = new ezcMvcCookieResult();
$cookie->name = 'LANG_REDIRECT';
$cookie->value= "YES";
$cookie->expires = new DateTime( 'Wed, 05 Nov 2008 09:12:03 GMT' );
$cookie->domain = '';
$cookie->path = '/';
$cookie->secure = false;
$cookie->httpOnly = false;
$result->cookies[] = $cookie;
// = Set-Cookie: LANG_REDIRECT=YES; expires=Wed, 05 Nov 2008 09:12:03 GMT; path=/

$result->content = new ezcMvcContentResult;

$result->content->language = 'en-GB';
// = Content-Language: en-GB

$result->content->type = 'text/html';
$result->content->charset = 'utf-8';
// = Content-Type: text/html; charset=utf-8

$result->content->encoding = 'gzip';
// = Content-Encoding: gzip
?>
