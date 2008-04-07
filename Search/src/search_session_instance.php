<?php
/**
 * File containing the ezcSearchSessionInstance class
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Holds search object session instances for global access throughout an application.
 *
 * Typical usage example:
 * <code>
 * $session = new ezcSearchSession( new ezcSearchSolrHandler( 'localhost', 6983 ),
 *                                  new ezcSessionDefinitionManager( ... ) );
 * ezcSearchSessionInstance::set( $session ); // set default session
 * $session2 = new ezcSearchSession( ezcDbInstance::get( 'other_db' ),
 *                                   new ezcSessionDefinitionManager( ... ) );
 * ezcSearchSessionInstance::set( $session2, 'extra' ); // set the extra session
 *
 * // retrieve the sessions
 * $session = ezcSearchSessionInstance::get();
 * $session2 = ezcSearchSessionInstance::get( 'extra' );
 * </code>
 *
 * @package Search
 * @version //autogen//
 * @mainclass
 */
class ezcSearchSessionInstance
{
    /**
     * Identifier of the instance that will be returned
     * when you call get() without arguments.
     *
     * @see ezcSearchSessionInstance::get()
     * @var string
     */
    static private $defaultInstanceIdentifier = null;

    /**
     * Holds the session instances.
     *
     * Example:
     * <code>
     * array( 'server1' => [object],
     *        'server2' => [object] );
     * </code>
     *
     * @var array(string=>ezcSearchSession)
     */
    static private $instances = array();

    /**
     * Returns the search session instance named $identifier.
     *
     * If $identifier is omitted the default search session specified by
     * chooseDefault() is returned.
     *
     * @throws ezcSearchSessionNotFoundException if the specified instance is not found.
     * @param string $identifier
     * @return ezcSearchSession
     */
    public static function get( $identifier = null )
    {
        if ( $identifier === null && self::$defaultInstanceIdentifier )
        {
            $identifier = self::$defaultInstanceIdentifier;
        }

        if ( !isset( self::$instances[$identifier] ) )
        {
            throw new ezcSearchSessionNotFoundException( $identifier );
        }

        return self::$instances[$identifier];
    }

    /**
     * Adds the search session $session to the list of known instances.
     *
     * If $identifier is specified the search session instance can be retrieved
     * later using the same identifier. If $identifier is omitted the default
     * instance will be set.
     *
     * @param ezcSearchSession $session
     * @param string $identifier the identifier of the search handler
     * @return void
     */
    public static function set( ezcSearchSession $session, $identifier = null )
    {
        if ( $identifier === null )
        {
            $identifier = self::$defaultInstanceIdentifier;
        }

        self::$instances[$identifier] = $session;
    }

    /**
     * Sets the search $identifier as default search instance.
     *
     * To retrieve the default search instance call get() with no parameters.
     *
     * @see ezcSearchSessionInstance::get().
     * @param string $identifier
     * @return void
     */
    public static function chooseDefault( $identifier )
    {
        self::$defaultInstanceIdentifier = $identifier;
    }

    /**
     * Resets the default instance holder.
     */
    public static function resetDefault()
    {
        self::$defaultInstanceIdentifier = false;
    }

    /**
     * Resets this object to its initial state.
     */
    public function reset()
    {
        $this->defaultInstanceIdentifier = false;
        $this->instances = array();
    }
}
?>
