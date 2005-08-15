<?php
/**
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
 * @filesource
 * @package UserInput
 */
/**
 * Provides access to form variables.
 *
 * This class allows you to retrieve input variables from the request in a save
 * way, by applying filters to allow only wanted data into your application. It
 * works by passing an array that describes your form definition to the
 * constructor of the class. The constructor will then initialize the class
 * with properties that contain the value of your request's input fields.
 *
 * Example:
 * <code>
 * <?php
 * $definition = array(
 *    'fieldname'  => array(REQUIRED, 'filtername'),
 *    'textfield'  => array(OPTIONAL, 'string', 25),
 *    'integer1'   => array(REQUIRED, 'integer', 0, 42),
 *    'xmlfield'   => array(REQUIRED, 'unsafe_raw'),
 *    'special'    => array(OPTIONAL, 'callback',
 *                                    array('ezcInputFilter', 'special')),
 * );
 * $form = new ezcInputForm(ezcInputForm::INPUT_GET, $definition);
 * if ( $form->hasInputField( 'textfield' ) ) // check for optional field
 * {
 *     $text = $form->textfield;
 * }
 *
 * try {
 *     $xml = $form->xmlfield; // Uses dynamic properties through __get().
 *     $field = $form->fieldname;
 *     $int = $form->integer1;
 * } catch (InputFormException $e) {
 *     // one of the required fields didn't have valid data.
 *     $invalidProperties = $form->invalidProperties();
 *
 *     // Retrieve RAW data for invalid properties so that we can fill in the
 *     // forms online with this RAW data again - Make sure to escape it on
 *     // output though, but that should be done for all data anyway.
 *     if ( in_array( 'xmlfield', $invalidProperties ) )
 *     {
 *         $xml = $form->getUnsafeRawData( 'xmlfield' );
 *     }
 * }
 *
 * // Checking optional fields
 * foreach ( $form->optionalProperties as $property )
 * {
 *     $name = "property_{$property}";
 *     if ( $form->hasValidData( $property ) )
 *     {
 *         $$name = $form->$property;
 *     }
 * }
 * ?>
 * </code>
 *
 * @package UserInput
 */
class ezcInputForm
{
    /**
     * @var INPUT_GET is used to select the $_GET superglobal as input source
     */
    const INPUT_GET = 1;

    /**
     * @var INPUT_POST is used to select the $_POST superglobal as input source
     */
    const INPUT_POST = 2;

    /**
     * @var INPUT_REQUEST is used to select the $_REQUEST superglobal as input
     *                    source
     */
    const INPUT_REQUEST = 3;

    /**
     * @var OPTIONAL marks an input field as "optional". Optional input fields
     *               do not throw errors if they are not available while
     *               parsing input variables.
     */
    const OPTIONAL = 0;

    /**
     * @var REQUIRED marks an input field as "required". When a required input
     *               variable is not available while parsing input variables,
     *               the __construct will throw the UserInputMissingData
     *               exception.
     */
    const REQUIRED = 1;

    /**
     * @var VALID is used in the $properties array to record whether the data
     *            in a specific input variable contained valid data according
     *            to the filter.
     */
    const VALID = 0;

    /**
     * @var INVALID is used in the $properties array to record whether the data
     *              in a specific input variable contained valid data according
     *              to the filter.
     */
    const INVALID = 1;

    /**
     * @var array Contains the definition for this form (as passed in the
     *            contructor).
     */
    private $definition;

    /**
     * @var array Contains a list of all retrieved properties and their status.
     *            The key for each array element is the field name, and the
     *            value associated with this key is one of the constants VALID
     *            or INVALID.
     */
    private $properties;

    /**
     * @var array Contains the values of the input variables.
     *            The key for each array element is the field name, and the
     *            value associated with this key is the property's valud. This
     *            array does not have an entry for input fields that do not
     *            have valid data.
     */
    private $propertyValues;

    /**
     * @param integer Selects the input source, can be any of the three INPUT_
     *                constants.
     * @param array   The definition array that contains the expected input
     *                variables. Each array element's key decribes the
     *                fieldname, and the element's value is an indexed array
     *                containing:
     *                - whether the field is optional or not (Use one of the
     *                  class constants REQUIRED or OPTIONAL)
     *                - the filter to be used for this fieldname (fieldnames
     *                  are defined through the PHP extension 'input_filter'
     *                - optional parameters for the filter.
     * @param string  The character encoding to use while retrieving input
     *                variable data.
     * @throws InputFormException exception when one of the required input
     *         variables is missing.
     */
    public function __construct($inputSource, $definition, $characterEncoding)
    {
    }

    /**
     * This function is called when a variable is assigned to one of the magic
     * properties.
     *
     * When the value of a property is requested this function checks with the
     * $properties array whether it contains valid data or not. If there is no
     * valid data, the UserInputInValidData exception is thrown, otherwise the
     * function returns the value associated with the input variable.
     *
     * @param   string The name of the property that is used in the assignment.
     * @returns mixed  The value of the input variable.
     * @throws  InputFormException exception when trying to read a property
     *          which has no valid data.
     */
    public function __get($propertyName)
    {
    }

    /**
     * This function is called when one of the magic properties was assigned a
     * new value too.
     *
     * As all magic properties are readonly for this class, all that this
     * function does is return the exception UserInputReadOnly.
     *
     * @param string The name of the property that was assigned a new value.
     * @param mixed  The new value that was assigned to this property.
     * @throws InputFormException exception for every call to this function.
     */
    public function __set($propertyName, $value)
    {
    }

    /**
     * This function returns whether an optional field was found while
     * retrieving input variables.
     *
     * @param  string The name of the input field that you want to check if it
     *                was parsed.
     * @return bool   true if the input field was available and false
     *                otherwise.
     */
    public function hasInputField($fieldName)
    {
    }

    /**
     * This function returns whether the filters for required field returned
     * valid data or not.
     *
     * @param  string The name of the input field that you want to check if it
     *                was parsed.
     * @return bool   true if the input field was available and false
     *                otherwise.
     */
    public function hasValidData($fieldName)
    {
    }

    /**
     * This function returns RAW input variable values for invalid fields only.
     *
     * The return value of this function can be used to prefil forms on the
     * next request. It will only work for invalid input fields, as for valid
     * input fields you should never have to get to the original RAW data.
     *
     * @param  string The name of the input field that you want to check if it
     *                was parsed.
     * @return string The original RAW data of the specified input field.
     * @throws InputFormException exception when trying to get unsafe raw data
     *         from a input field with valid data.
     */
    public function getUnsafeRawData($fieldName)
    {
    }

    /**
     * This function returns a list with all optional properties.
     * @return array
     */
    public function optionalProperties()
    {
    }

    /**
     * This function returns a list with all required properties.
     * @return array
     */
    public function requiredProperties()
    {
    }

    /**
     * This function returns a list with all properties that have valid data.
     * @return array
     */
    public function validProperties()
    {
    }

    /**
     * This function returns a list with all properties having invalid data.
     * @return array
     */
    public function invalidProperties()
    {
    }
}
