<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Dispatcher interface.
 *
 * A dispatcher is the glue code that binds all the other parts of the MvcTools
 * package together. 
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
interface ezcMvcDispatcher
{
    /**
     * Runs the dispatcher.
     */
    public function run();
}
?>
