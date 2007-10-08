<?php

abstract class ezcWebdavPluginConfiguration
{
    /**
     * Returns the hooks this plugin wants to assign to.
     *
     * This method is called by {@link ezcWebdavPluginRegistry}, as soon as the
     * plugin is registered to be used. The method must return a structured
     * array, representing the hooks the plugin want to be notified about.
     *
     * The returned array must be of the following structure:
     * <code>
     *  array(
     *      '<className>' => array(
     *          '<hookName>' => array(
     *              <callback1>,
     *              <callback2>,
     *          ),
     *          '<anotherHookName>' => array(
     *              <callback3>,
     *          ),
     *      ),
     *      '<secondClassName>' => array(
     *          '<thirdHookName>' => array(
     *              <callback1>,
     *              <callback3>,
     *          ),
     *      ),
     *  )
     * </code>
     * 
     * @return array
     */
    public abstract function getHooks();

    /**
     * Returns the namespace of this plugin.
     *
     * The namespace of a plugin is a unique identifier string that allows it
     * to be recognized bejond other plugins. The namespace is used to provide storage for the plugin in the 
     * 
     * @return void
     */
    public abstract function getNamespace();

    public abstract function init();
}

?>
