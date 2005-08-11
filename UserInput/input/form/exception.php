<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * General exception for use in {@see ezcUserInput} class.
 * 
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcInputFormException extends Exception
{

    /**
     * One of the REQUIRED input variables is missing in the input variable
     * source.
     */
    const INPUT_VARIABLE_MISSING = 1;

    /**
     * The property where was read from has no valid data associated to it.
     */
    const NO_VALID_DATA = 2;

    /**
     * An attempt to set one of the properties of the class was made.
     */
    const READ_ONLY = 3;

    /**
     * Valid data was associated with an input variable, but the raw data was
     * requested through ezcInputForm::getUnsafeRawData().
     */
    const NO_ACCESS_VALID_DATA_AVAILABLE = 4;
}
