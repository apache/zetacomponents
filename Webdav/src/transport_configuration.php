<?php
/**
 * File containing the ezcWebdavTransportConfiguration class
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Class containing the configuration for a transport.
 *
 * An instance of this class represents the configuration necessary to
 * instanciate a new {@link ezcWebdavTransport} object. The {@link
 * ezcWebdavTransportDispatcher} holds a default set of such objects,
 * representing the transport classes that are known by the Webdav component by
 * default.
 *
 * You can instanciate more objects of this class to add custom configurations
 * and possibly even extend it to support more advanced features.
 *
 * This base class instantiates a transport in the way that is suitable, when
 * requested by the {@link ezcWebdavTransportDispatcher}. The class may be
 * extended to suite extended transport layer needs. The only premission is,
 * that the getTransportInstance() method returns a functional {@link
 * ezcWebdavTransport} instance.
 *
 * The property $userAgentRegex determines the PCRE that is used to match
 * against the User-Agent HTTP header. If the regex matches, the transport
 * is instanciated and made responsible to handle the request. The default
 * regex will match always and therefore always use the transport
 * configured by this class.
 *
 * The $transport property represents the class to be instanciated as the
 * real transport. The default is ezcWebdavTransport, which is the RFC
 * compliant transport implementation.
 *
 * $xmlTool defaults to the ezcWebdavXmlTool class, but may be configured
 * to be a class implementing the same interface or even an extended one.
 * The premission is, that the transport is able to use the instance of
 * this class for XML handling purposes.
 *
 * The property $propertyHandler is responsible for extraction of and
 * serialization to XML of dead and live properties. This may be replaced,
 * if a transport needs or provides non-conform  property XML.
 *
 * @property string $userAgentRegex
 *           PCRE that is used to match against the User-Agent header. If this
 *           regex matches, this configuration object is used to create the
 *           transport layer classes for the current request, determined by the
 *           other properties.
 * @property string $transport
 *           Transport class to instanciate when creating an instance of the
 *           transport layer configured in this object. If the desired
 *           extension of {@link ezcWebdavTransport} is compatible API with the
 *           basic RFC implementation, it can also be used here.
 * @property ezcWebdavPathFactory $pathFactory
 *           Object used to transform real paths into request paths. Default is
 *           {@link ezcWebdavAutomaticPathFactory}. This is the only place
 *           where an object is expected, since transport implementations
 *           should not rely on a specific path factory and that means 1 path
 *           factory can be used for all transport configurations.
 * @property string $xmlTool
 *           This property defines the {@link ezcWebdavXmlTool} instance to be
 *           used with the {@link ezcWebdavTransport} class configured in
 *           $transport and the {@link ezcWebdavPropertyHandler} class
 *           configured in $propertyHandler.
 * @property string $propertyHandler
 *           This property defines the {@link ezcWebdavPropertyHandler} class
 *           to use, when instanciating the {@link ezcWebdavTransport} in
 *           $transport. The class given here will receive $xmlTool as a
 *           parameter, to work with.
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavTransportConfiguration
{
    /**
     * Properties. 
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new instance.
     *
     * All parameters are strings, representing the specific classes to use.
     * 
     * @param string $userAgentRegex 
     * @param string $transport 
     * @param string $xmlTool 
     * @param string $propertyHandler 
     * @param ezcWebdavPathFactory $pathFactory 
     * @return void
     */
    public function __construct(
        $userAgentRegex  = '(.*)',
        $transport       = 'ezcWebdavTransport',
        $xmlTool         = 'ezcWebdavXmlTool',
        $propertyHandler = 'ezcWebdavPropertyHandler',
        ezcWebdavPathFactory $pathFactory = null
    )
    {
        $this->properties['userAgentRegex']  = null;
        $this->properties['transport']       = null;
        $this->properties['xmlTool']         = null;
        $this->properties['propertyHandler'] = null;
        $this->properties['pathFactory']     = null;

        $this->userAgentRegex                = $userAgentRegex;
        $this->transport                     = $transport;
        $this->xmlTool                       = $xmlTool;
        $this->propertyHandler               = $propertyHandler;
        $this->pathFactory                   = $pathFactory === null ? new ezcWebdavAutomaticPathFactory() : $pathFactory;
    }

    /**
     * Returns a new transport instance according to the property values.
     *
     * This method returns a new instance of the {@link ezcWebdavTransport}
     * configured in the {@link $this->transport} property. The {@link
     * $this->pathFactory}, {@link $this->xmlTool} and {@link
     * $this->propertyHandler} properties are used to configure the transport.
     *
     * This base class takes the raw interface defined for {@link
     * ezcWebdavTransport} as given to instanciate the transport. If your
     * transport class has different needs, you need to extend this class to
     * suite your needs.
     * 
     * @return ezcWebdavTransport
     */
    public function getTransportInstance()
    {
        $this->checkClasses();

        $xmlTool         = new $this->xmlTool();
        $propertyHandler = new $this->propertyHandler( $xmlTool );
        return             new $this->transport(
            $xmlTool,
            $propertyHandler,
            $this->pathFactory
        );
    }

    /**
     * Checks the availability of all classes to instanciate.
     *
     * This method checks all classes stored in {@link $this->properties} for
     * existance and validity. If an error is found, an {@link
     * ezcBaseValueException} is issued.
     * 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if a property does not contain a class valid to be used with
     *         this configuration class or if a given class does not exist.
     */
    protected function checkClasses()
    {
        foreach ( $this->properties as $propertyName => $propertyValue )
        {
            if ( $propertyName !== 'userAgentRegex' && is_string( $propertyValue ) && !class_exists( $propertyValue ) )
            {
                throw new ezcBaseValueException( $propertyName, $propertyValue, 'name of existining, loadable class' );
            }
        }
        switch ( true )
        {
            case ( $this->transport !== 'ezcWebdavTransport' && !is_subclass_of( $this->transport, 'ezcWebdavTransport' ) ):
                throw new ezcBaseValueException( 'transport', $this->transport, 'ezcWebdavTransport or derived' );

            case ( !( $this->pathFactory instanceof ezcWebdavPathFactory ) ):
                throw new ezcBaseValueException( 'pathFactory', $this->pathFactory, 'ezcWebdavPathFactory or derived' );

            case ( $this->xmlTool !== 'ezcWebdavXmlTool' && !is_subclass_of( $this->xmlTool, 'ezcWebdavXmlTool' ) ):
                throw new ezcBaseValueException( 'xmlTool', $this->xmlTool, 'ezcWebdavXmlTool or derived' );

            case ( $this->propertyHandler !== 'ezcWebdavPropertyHandler' && !is_subclass_of( $this->propertyHandler, 'ezcWebdavPropertyHandler' ) ):
                throw new ezcBaseValueException( 'propertyHandler', $this->propertyHandler, 'ezcWebdavPropertyHandler or derived' );
        }
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'userAgentRegex':
            case 'transport':
            case 'xmlTool':
            case 'propertyHandler':
                if ( !is_string( $propertyValue ) || strlen( $propertyValue ) < 1 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'string, length > 0' );
                }
                break;
            case 'pathFactory':
                if ( !is_object( $propertyValue ) || !( $propertyValue instanceof ezcWebdavPathFactory ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavPathFactory' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property get access.
     * Simply returns a given property.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property propertys is not an instance of
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) === true )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Returns if a property exists.
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}
?>
