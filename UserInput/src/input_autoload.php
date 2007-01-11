<?php
/**
 * Autoloader definition for the UserInput component.
 *
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package UserInput
 */

ezcBase::checkDependency( 'UserInput', ezcBase::DEP_PHP_EXTENSION, "filter" );

return array(
    'ezcInputForm'                            => 'UserInput/input_form.php',
    'ezcInputFormDefinitionElement'           => 'UserInput/structs/definition_element.php',
    'ezcInputFilter'                          => 'UserInput/input_filter.php',

    'ezcInputFormException'                   => 'UserInput/exceptions/exception.php',
    'ezcInputFormFieldNotFoundException'      => 'UserInput/exceptions/field_not_found.php',
    'ezcInputFormInvalidDefinitionException'  => 'UserInput/exceptions/invalid_definition.php',
    'ezcInputFormNoValidDataException'        => 'UserInput/exceptions/no_valid_data.php',
    'ezcInputFormUnknownFieldException'       => 'UserInput/exceptions/unknown_field.php',
    'ezcInputFormValidDataAvailableException' => 'UserInput/exceptions/valid_data_available.php',
    'ezcInputFormVariableMissingException'    => 'UserInput/exceptions/input_variable_missing.php',
    'ezcInputFormWrongInputSourceException'   => 'UserInput/exceptions/wrong_input_source.php',
);

?>
