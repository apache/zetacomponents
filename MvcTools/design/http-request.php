GET /rss/foo2?tequila=good HTTP/1.1
Host: foobar.ez.no
User-Agent: Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9) Gecko/2008062908 Iceweasel/3.0 (Debian-3.0~rc2-2)
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en,en-us;q=0.8,nb;q=0.5,nl;q=0.3
Accept-Encoding: gzip,deflate
Accept-Charset: UTF-8,*
Keep-Alive: 3000
Connection: keep-alive
Cookie: LANG_REDIRECT=YES; __utmz=269809701.1214833203.39.22.utmcsr=project.issues.ez.no|utmccn=(referral)|utmcmd=referral|utmcct=/homepage.php; __utma=269809701.1018051692.1204710327.1214833203.1214837947.40; PHPSESSID=26d49809fdde5cec708dbd5cb143d59c
<?php
$req = new ezcMvcRequest();

$req->date = new DateTime();
$req->protocol = 'http-get';
$req->host = 'foobar.ez.no';
$req->uri = '/rss/foo2?tequila=good';
$req->fullUri = 'foobar.ez.no/rss/foo2?tequila=good';
$req->requestId = 'foobar.ez.no/rss/foo';
$req->referrer = '';

$req->variables =& $_REQUEST;
$req->body = '';
$req->files = array();

$req->accept = new ezcMvcRequestAccept;
$req->accept->types = array(
	'text/html', 'application/xhtml+xml', 'application/xml', '*/*' );
$req->accept->charsets = array( 'UTF-8', '*' );
$req->accept->languages = array( 'en', 'en-us', 'nb', 'nl' );
$req->accept->encodings = array( 'gzip', 'deflate' );

$req->agent = new ezcMvcRequestUserAgent;
$req->agent->agent = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9) Gecko/2008062908 Iceweasel/3.0 (Debian-3.0~rc2-2)';

$req->authentication = new ezcMvcRequestAuthentication;

$req->raw = new ezcMvcHttpRawRequest;
$req->raw->headers['Host'] = 'foobar.ez.no';
$req->raw->headers['User-Agent'] = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9) Gecko/2008062908 Iceweasel/3.0 (Debian-3.0~rc2-2)';
/* ... */
$req->raw->headers['Cookie'] = 'LANG_REDIRECT=YES; __utmz=269809701.1214833203.39.22.utmcsr=project.issues.ez.no|utmccn=(...';

$req->raw->body = file_get_contents( 'php://stdin' );
?>
