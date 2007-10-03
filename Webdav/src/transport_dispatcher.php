<?php

class ezcWebdavTransportDispatcher implements ArrayAccess, Iterator
{
    /**
     * Transport configurations to dispatch. 
     * 
     * @var array(int=>ezcWebdavTransportConfiguration)
     */
    protected $transportConfigurations = array();

    /**
     * Creates a new dispatcher.
     *
     * This creates a new dispatcher object and registers the default {@link
     * ezcWebdavTransportConfiguration} automatically. That means, all
     * following should be added by {@link $this->insertBefore()} to ensure,
     * this catchall will not break the transfer layer.
     * 
     * @return void
     */
    public function __construct()
    {
        // Add default RFC transport for now
        $this[] = new ezcWebdavTransportConfiguration();
    }

    /**
     * Inserts a configuration right before a certain offset.
     *
     * This method inserts a given $config right before the given $offset. The
     * $offset must be of type integer and between 0 and the number of elements
     * in {@link $this->transportConfigurations} minus 1.
     *
     * If these preconditions do not match for the given $offset, an
     * ezcBaseValueException is thrown.
     * 
     * @param ezcWebdavTransportConfiguration $config 
     * @param int $offset 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if the given $offset is not an integer that is larger or equal
     *         to 0 and smaller than the number of elements in {@link
     *         $this->transportConfigurations}.
     */
    public function insertBefore( ezcWebdavTransportConfiguration $config, $offset = 0 )
    {
        if ( !is_int( $offset ) || $offset < 0 || $offset > ( count( $this->transportConfigurations ) - 1 ) )
        {
            throw new ezcBaseValueException( 'index', $offset, 'int >= 0, < number of transport configurations' );
        }
        array_splice( $this->transportConfigurations, $offset, 0, array( $config ) );
    }

    /**
     * Retrive a transport that is capable of handling the request.
     *
     * This method is used by {@link ezcWebdavServer} to determine the correct
     * {@link ezcWebdavTransport} for the current request. It returns the
     * {@link ezcWebdavTransport} created by the {@link
     * ezcWebdavTransportConfiguration} which matched the submitted User-Agent
     * header first.
     *
     * Per default, the RFC compliant default implementation {@link
     * ezcWebdavTransport} is configured to catch all User-Agent headers for
     * which no specific implementation could be found. If this configuration
     * has been removed or manipulated incorrectly, an {@link
     * ezcWebdavMissingTransportConfigurationException} might be thrown.
     * 
     * @param mixed $userAgent 
     * @return void
     *
     * @throws ezcWebdavMissingTransportConfigurationException
     *         if no {@link ezcWebdavTransportConfiguration} could be found
     *         that matches the given $userAgent.
     */
    public function createTransport( $userAgent )
    {
        foreach ( $this as $transportConfiguration )
        {
            if ( preg_match( $transportConfiguration->userAgentRegex, $userAgent ) > 0 )
            {
                return $transportConfiguration->getTransportInstance();
            }
        }
        throw new ezcWebdavMissingTransportConfigurationException( $userAgent );
    }

    /**
     * Checks the given $offset for validity.
     *
     * This method checks if the given $offset is either of type int, then
     * larger 0 and not larger as the number of elements in {@link
     * $this->transportConfigurations}, or null.
     *
     * The method is primarily used in the {@link ArrayAccess} methods.
     * 
     * @param int|null $offset 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if the given $offset is not an an int with the given criteria
     *         and not null.
     */
    protected function checkOffset( $offset )
    {
        if ( ( !is_int( $offset ) || $offset < 0 || $offset > count( $this->transportConfigurations ) ) && $offset !== null )
        {
            throw new ezcBaseValueException( 'offset', $offset, 'int >= 0, <= number of transport configurations' );
        }
    }

    /**
     * Checks the given $value for validity.
     *
     * This method checks if the given $value is either an instance of {@link
     * ezcWebdavTransportConfiguration} or null.
     *
     * The method is primarily used in the {@link ArrayAccess} methods.
     * 
     * @param ezcWebdavTransportConfiguration|null $value 
     * @return void
     *
     * @throws ezcBaseValueException
     *         if the given $value is not an instance of
     *         ezcWebdavTransportConfiguration or null.
     */
    protected function checkValue( $value )
    {
        if ( !( $value instanceof ezcWebdavTransportConfiguration ) && $value !== null )
        {
            throw new ezcBaseValueException( 'value', $value, 'ezcWebdavTransportConfiguration' );
        }
    }

    // ArrayAccess

    /**
     * Array set access. 
     * 
     * @param string $offset 
     * @param string $value 
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        $this->checkOffset( $offset );
        $this->checkValue( $value );

        if ( $value === null )
        {
            return $this->offsetUnset( $offset );
        }
        if ( $offset === null )
        {
            $offset = count( $this->transportConfigurations );
        }
        $this->transportConfigurations[$offset] = $value;
    }

    /**
     * Array get access.
     * 
     * @param string $offset 
     * @return string
     * @ignore
     */
    public function offsetGet( $offset )
    {
        $this->checkOffset( $offset );
        if ( !isset( $this->transportConfigurations[$offset] ) )
        {
            return null;
        }
        return $this->transportConfigurations[$offset];
    }

    /**
     * Array unset() access.
     *
     * @param string $offset 
     * @return void
     * @ignore
     */
    public function offsetUnset( $offset )
    {
        $this->checkOffset( $offset );
        if ( $offset === null || $offset === count( $this->transportConfigurations ) )
        {
            return;
        }

        array_splice( $this->transportConfigurations, $offset, 1 );
    }

    /**
     * Array isset() access.
     * 
     * @param string $offset 
     * @return bool
     * @ignore
     */
    public function offsetExists( $offset )
    {
        return isset( $this->transportConfigurations[$offset] );
    }

    // Iterator

    /**
     * Implements current() for Iterator
     * 
     * @return mixed
     */
    public function current()
    {
        return current( $this->transportConfigurations );
    }

    /**
     * Implements key() for Iterator
     * 
     * @return int
     */
    public function key()
    {
        return key( $this->transportConfigurations );
    }

    /**
     * Implements next() for Iterator
     * 
     * @return mixed
     */
    public function next()
    {
        return next( $this->transportConfigurations );
    }

    /**
     * Implements rewind() for Iterator
     * 
     * @return void
     */
    public function rewind()
    {
        return reset( $this->transportConfigurations );
    }

    /**
     * Implements valid() for Iterator
     * 
     * @return boolean
     */
    public function valid()
    {
        return ( current( $this->transportConfigurations ) !== false );
    }

}

?>
