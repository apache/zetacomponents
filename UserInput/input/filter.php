<?php
/**
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
 * @filesource
 * @package UserInput
 */
/**
 * Provides a set of standard filters.
 *
 * This class defines a set of filters that can be used with both with PHP's
 * filter extension, or with the ezcInputForm class as callback filter method.
 *
 * <code>
 * <?php
 * $definition = array(
 *    'special' => array(OPTIONAL, 'callback',
 *                                 array('ezcInputFilter', 'urlFilter')),
 * );
 * $form = new ezcInputForm(ezcInputForm::INPUT_GET, $definition);
 * ?>
 * </code>
 *
 * @package UserInput
 */
class ezcInputFilter
{
    /**
     * Receives a variable for filtering. The filter function is free to modify
     * the variable. If 'false' is returned, the filter will be considered as
     * having failed, and if 'true' is returned, the filter will be considered
     * as having succeeded.
     *
     * @param string  The variable's value
     * @param string  The value's character set
     * @returns boolean Whether the filter matched succesfully or not
     */
    static function urlFilter( &$value, $characterSet )
    {
    }
}
