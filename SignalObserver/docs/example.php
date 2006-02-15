<?php
/**
 * File containing an example for the ezcSignalObserver class.
 *
 * @package SignalObserver
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * EXMAPLE: Simple content object class. Will emit several signals.
 * This class is refered to as the $srcClass in the ezcSignalObserver.
 */
class ContentObject
{
    /**
     * Simple constructor.
     *
     * @param int $id ID.
     */
    public function __construct( $id )
    {
        $this->id = $id;
    }

    /**
     * Remove content.
     * Removes content and emits signal that content has been removed.
     *
     */
    function remove()
    {
        // Perform action to remove content...
        // Afterwards emit signal that content has been removed.
        ezcSignalObserver::getInstance()->emit( __CLASS__, 'removed', $this );
    }

    /**
     * Publish content.
     * Publishes content and emits signal that content has been published.
     *
     */
    function publish()
    {
        // Perform action to publish content...
        // Afterwards emit signal that content has been published.
        ezcSignalObserver::getInstance()->emit( __CLASS__, 'published', $this );
    }
}

/**
 * EXMAPLE: Simple bug object class. Will receive emitted signals.
 * This class is refered to as the $destClass in the ezcSignalObserver.
 */
class Bug
{
    /**
     * Method, performing some actions.
     *
     * @param mixed $contentId Some ID.
     */
    public function removeByContentID( $contentId )
    {
        // Perform the actions...
    }

    /**
     * Another method, performing some actions.
     *
     * @param mixed $contentId Some ID.
     * @param mixed $expire    Some timestamp.
     */
    public function updateByContentID( $contentID, $expire )
    {
        // Perform the actions...
    }
    
    /**
     * Slot method.
     * This is a method that is refered to as $slot inside ezcSignalObserver.
     * This method is called later when a specific signal is emmited, where
     * this slot is connected to. See, that every slot method at least defined 
     * the 3 parameters defined in {ezcSignalObserver::emit()}. 
     * 
     * @param string $source               In ezcSignalObserver this is $srcClass.
     * @param string $signal               The signal.
     * @param ContentObject $contentObject In ezcSignalObserver this is $data.
     */
    public static function contentRemoved( $source, $signal, ContentObject $contentObject )
    {
        // Handle the emitted signal.
        $bug = new Bug();
        $bug->removeByContentID( $contentObject->id );
    }

    /**
     * Slot method.
     * This is a method that is refered to as $slot inside ezcSignalObserver.
     * This method is called later when a specific signal is emmited, where
     * this slot is connected to. See, that every slot method at least defined 
     * the 3 parameters defined in {ezcSignalObserver::emit()}. This method
     * actually expects 2 data parameters.
     *
     * @param string $source               In ezcSignalObserver this is $srcClass.
     * @param string $signal               The signal.
     * @param ContentObject $contentObject In ezcSignalObserver this is $data.
     * @param int $expire                  In ezcSignalObserver this is $data.
     */
    public static function contentUpdated( $source, $signal, $contentObject, $expire )
    {
        // Handle the emitted signal.
        Bug::updateByContentID( $contentObject->id, $expire );
    }
}

/**
 * -- Example for a simple application, using manually defined connections. --
 */


/**
 * Set up the connections.
 */

// Wheneve a ContentObject removes some content, the Bug class is
// informed about that.
ezcSignalObserver::getInstance()->connect( 'ContentObject', 'removed',
                                           'Bug', 'contentRemoved' );
// Wheneve a ContentObject publishes some content, the Bug class is
// informed about that.
ezcSignalObserver::getInstance()->connect( 'ContentObject', 'published',
                                           'Bug', 'contentUpdated' );
/**
 * Start emitting signals.
 */

// New object
$obj = new ContentObject( 1 );

// Now the "contentUpdated" signal will be emitted.
$obj->publish();

// Now the "contentRemoved" signal will be emitted.
$obj->remove();

/**
 * -- Example for a large application, using configuration defined connections. --
 */

// Retreive connections configured.
$connections = getConfiguredConnections();

// Register all connections at once
ezcSignalObserver::getInstance()->setConnections( $connections );

/**
 * -- Example for a large application, using self registering modules. --
 */

// Retreive observer instance
$observer = ezcSignalObserver::getInstance();

// Retreive all extensions available
$extensions = initConfiguredExtensions();

// Let each extension register it's connections
foreach ( $extensions as $extension )
{
    $extension->registerConnections( $observer );
    $extension->registerSlots( $observer );
}

// Retreive all registered connections
$connections = $observer->getConnections();
?>
