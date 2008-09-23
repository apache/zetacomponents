<?php
/**
 * The request object holds the request data.
 *
 * The request object should be created by the request parser
 * in the first place.
 * It may also be returned by the controller, in the case of an
 * internal redirection.
 *
 * It holds the protocol dependant data in an ezcMvcRawRequest
 * object that is held in property $raw.
 *
 * It holds several structs which contain some protocol abstract
 * data in the following properties:
 * - $files: array of instances of ezcMvcRequestFile.
 * - $cache: instance of ezcMvcRequestCache
 * - $content: instance of ezcMvcRequestContent
 * - $agent: instance of ezcMvcRequestAgent
 * - $authentication: instance of ezcMvcRequestAuthentication
 *
 * It holds request variables like an array. For example, to hold
 * a 'controller' GET variable in $request['controller'].
 *
 * @package MvcTools
 * @version //autogen//
 */
class ezcMvcRequest extends ezcBaseStruct
{
    /**
     * Date of the request
     *
     * @var DateTime
     */
    public $date;

    /**
     * Protocol description in a normalized form
     * F.e. http-get, http-post, http-delete, mail, jabber
     *
     * @var string
     */
    public $protocol;

    /**
     * Hostname of the requested server
     *
     * @var string
     */
    public $host;

    /**
     * Uri of the requested resource
     *
     * @var string
     */
    public $uri;

    /**
     * Full Uri - combination of host name and uri in a protocol independent
     * order
     *
     * @var string
     */
    public $requestId;

    /**
     * Request ID of the referring URI in the same format as $requestId
     *
     * @var string
     */
    public $referrer;

    /**
     * Request variables.
     * 
     * @var array
     */
    public $variables = array();

    /**
     * Request body.
     * 
     * @var string
     */
    public $body = '';

    /**
     * Files bundled with the request.
     * 
     * @var array(ezcMvcRequestFile)
     */
    public $files;

    /**
     * Request content type informations.
     * 
     * @var ezcMvcRequestAccept
     */
    public $accept;

    /**
     * Request user agent informations.
     * 
     * @var ezcMvcRequestUserAgent
     */
    public $agent;

    /**
     * Request authentication data.
     * 
     * @var ezcMvcRequestAuthentication
     */
    public $authentication;

    /**
     * Raw request data
     * 
     * @var ezcMvcRawRequest
     */
    public $raw;

    /**
     * Invokes a new ezcMvcRequest
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct( $this->variables );
    }
}
?>
