<?php
/**
 * File containing the ezcWebdavNamespaceRegistry class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class to map XML namespaces to their shortcuts.
 *
 * An instance of this class is used in {@link ezcWebdavTransport} to keep
 * track of used namespaces and create new ones, if necessary.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavNamespaceRegistry implements ArrayAccess
{
    /**
     * Counter to create new shortcuts.
     * 
     * @var int
     */
    protected $shortcutCounter = 0;

    /**
     * Base string to be used for new shortcuts.
     * 
     * @var string
     */
    protected $shortcutBase = 'ezc';

    /**
     * Maps namespace URIs to shortcuts.
     * 
     * <code>
     * array(
     *      'uri' => '<shortcut>',
     *      // ...
     * )
     * </code>
     *
     * @var array(string=>string)
     */
    protected $namespaceMap = array();

    /**
     * Stores shortcuts that are already in use.
     *
     * <code>
     * array(
     *      '<shortcut>' => true,
     *      // ...
     * )
     * </code>
     * 
     * @var array(string=>bool)
     */
    protected $usedShortcuts = array();

    /**
     * Create a new namespace registry.
     *
     * Registers the standard namespace 'DAV:' with the shortcut 'D'.
     * 
     * @return void
     */
    public function __construct()
    {
        $this['DAV:'] = 'D';
    }

    /**
     * Array set access. 
     * 
     * @param string $offset 
     * @param string $value 
     * @return void
     */
    public function offsetSet( $offset, $value )
    {
        if ( isset( $this->namespaceMap[$offset] ) )
        {
            throw new ezcBaseValueException(
                'offset',
                $offset,
                'non-existent'
            );
        }
        $this->namespaceMap[$offset] = $value;
        $this->usedShortcuts[$value] = true;
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
        if ( isset( $this->namespaceMap[$offset] ) === false )
        {
            $this[$offset] = $this->newShortcut();
        }
        return $this->namespaceMap[$offset];
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
        if ( isset( $this->namespaceMap[$offset] ) )
        {
            unset( $this->usedShortcuts[$this->namespaceMap[$offset]] );
            unset( $this->namespaceMap[$offset] );
        }
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
        return isset( $this->namespaceMap[$offset] );
    }
    
    /**
     * Creates a new namespace shortcut.
     * Produces a new shortcut for a namespace by using {@link
     * $this->shortcutBase} and the first 5 characters of the MD5 hash of the
     * current microtime. Only returns unused shortczus.
     * 
     * @return string
     */
    protected function newShortcut()
    {
        do
        {
            $shortcut = sprintf( "%s%'05s" , $this->shortcutBase, $this->shortcutCounter++ );
        }
        while ( isset( $this->usedShortcuts[$shortcut] ) === true );
        return $shortcut;
    }
}

?>
