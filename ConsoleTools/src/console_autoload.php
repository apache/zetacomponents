<?php
/**
 * Autoload map for ConsoleTools package. 
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array (
    'ezcConsoleOutput'                              => 'ConsoleTools/output.php',
    'ezcConsoleOutputOptions'                       => 'ConsoleTools/structs/output_options.php',
    'ezcConsoleOutputFormats'                       => 'ConsoleTools/structs/output_formats.php',
    'ezcConsoleOutputFormat'                        => 'ConsoleTools/structs/output_format.php',
    'ezcConsoleInput'                               => 'ConsoleTools/input.php',
    'ezcConsoleOption'                              => 'ConsoleTools/input/option.php',
    'ezcConsoleOptionRule'                          => 'ConsoleTools/structs/option_rule.php',
    'ezcConsoleTable'                               => 'ConsoleTools/table.php',
    'ezcConsoleTableRow'                            => 'ConsoleTools/table/row.php',
    'ezcConsoleTableCell'                           => 'ConsoleTools/table/cell.php',
    'ezcConsoleTableOptions'                        => 'ConsoleTools/structs/table_options.php',
    'ezcConsoleProgressbar'                         => 'ConsoleTools/progressbar.php',
    'ezcConsoleProgressbarOptions'                  => 'ConsoleTools/structs/progressbar_options.php',
    'ezcConsoleStatusbar'                           => 'ConsoleTools/statusbar.php',

    'ezcConsoleException'                           => 'ConsoleTools/exceptions/exception.php',
    'ezcConsoleNoPositionStoredException'           => 'ConsoleTools/exceptions/no_position_stored.php',

    'ezcConsoleOptionAlreadyRegisteredException'    => 'ConsoleTools/exceptions/option_already_registered.php',
    'ezcConsoleOptionNoAliasException'              => 'ConsoleTools/exceptions/option_no_alias.php',
    'ezcConsoleOptionStringNotWellformedException'  => 'ConsoleTools/exceptions/option_string_not_wellformed.php',
    'ezcConsoleInvalidOptionNameException'          => 'ConsoleTools/exceptions/invalid_option_name.php',
    
    'ezcConsoleOptionException'                     => 'ConsoleTools/exceptions/option.php',
    
    'ezcConsoleOptionArgumentsViolationException'   => 'ConsoleTools/exceptions/option_arguments_violation.php',
    'ezcConsoleOptionDependencyViolationException'  => 'ConsoleTools/exceptions/option_dependency_violation.php',
    'ezcConsoleOptionExclusionViolationException'   => 'ConsoleTools/exceptions/option_exclusion_violation.php',
    'ezcConsoleOptionMandatoryViolationException'   => 'ConsoleTools/exceptions/option_mandatory_violation.php',
    'ezcConsoleOptionTypeViolationException'        => 'ConsoleTools/exceptions/option_type_violation.php',
    'ezcConsoleOptionMissingValueException'         => 'ConsoleTools/exceptions/option_missing_value.php',
    'ezcConsoleOptionNotExistsException'            => 'ConsoleTools/exceptions/option_not_exists.php',
    'ezcConsoleOptionTooManyValuesException'        => 'ConsoleTools/exceptions/option_too_many_values.php',
);

?>
