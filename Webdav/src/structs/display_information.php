<?php
/**
 * File containing the ezcWebdavDisplayInformation base struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Display information base class.
 *
 * Instances of classes extending this base class are used inside {@link
 * ezcWebdavTransport} to encapsulate response information to be displayed.
 * 
 * @version //autogentag//
 * @package Webdav
 */
abstract class ezcWebdavDisplayInformation
{
    /**
     * Response object to extract headers from.
     * 
     * @var ezcWebdavResponse
     */
    public $response;

    /**
     * Representation of the response body.
     *
     * The concrete data type of this property is defined in the extending
     * classes.
     * 
     * @var DOMDocument|sring|null
     */
    public $body;
    
    /**
     * Creates a new display information.
     *
     * By default an instance of this class carries a {@link ezcWebdavResponse}
     * $repsonse object, which holds header information, and a $body. The
     * content of $body depends on the type of display information. Extending
     * classes may possibly not carry a body at all.
     * 
     * @param ezcWebdavResponse $response 
     * @param DOMDocument|string|null $body 
     * @return void
     */
    public function __construct( ezcWebdavResponse $response, $body )
    {
        $this->response = $response;
        $this->body     = $body;
    }
}

?>
