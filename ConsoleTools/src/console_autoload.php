<?php
/**
 * Autoload map for ConsoleTools package. 
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

return array (
    'ezcConsoleOutput'                              => 'ConsoleTools/output.php',
    'ezcConsoleOutputOptions'                       => 'ConsoleTools/options/output.php',
    'ezcConsoleOutputFormats'                       => 'ConsoleTools/structs/output_formats.php',
    'ezcConsoleOutputFormat'                        => 'ConsoleTools/structs/output_format.php',
    'ezcConsoleInput'                               => 'ConsoleTools/input.php',
    'ezcConsoleOption'                              => 'ConsoleTools/input/option.php',
    'ezcConsoleOptionRule'                          => 'ConsoleTools/structs/option_rule.php',
    'ezcConsoleTable'                               => 'ConsoleTools/table.php',
    'ezcConsoleTableRow'                            => 'ConsoleTools/table/row.php',
    'ezcConsoleTableCell'                           => 'ConsoleTools/table/cell.php',
    'ezcConsoleTableOptions'                        => 'ConsoleTools/options/table.php',
    'ezcConsoleProgressbar'                         => 'ConsoleTools/progressbar.php',
    'ezcConsoleProgressbarOptions'                  => 'ConsoleTools/options/progressbar.php',
    'ezcConsoleProgressMonitor'                     => 'ConsoleTools/progressmonitor.php',
    'ezcConsoleProgressMonitorOptions'              => 'ConsoleTools/options/progressmonitor.php',
    'ezcConsoleStatusbar'                           => 'ConsoleTools/statusbar.php',
    'ezcConsoleStatusbarOptions'                    => 'ConsoleTools/options/statusbar.php',

    'ezcConsoleException'                           => 'ConsoleTools/exceptions/exception.php',
    'ezcConsoleNoPositionStoredException'           => 'ConsoleTools/exceptions/no_position_stored.php',
    'ezcConsoleInvalidOutputTargetException'        => 'ConsoleTools/exceptions/invalid_output_target.php',

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

    'ezcConsoleDialog'                              => 'ConsoleTools/interfaces/dialog.php',
    'ezcConsoleDialogValidator'                     => 'ConsoleTools/interfaces/dialog_validator.php',
    'ezcConsoleQuestionDialogValidator'             => 'ConsoleTools/interfaces/question_dialog_validator.php',
    'ezcConsoleDialogViewer'                        => 'ConsoleTools/dialog_viewer.php',
    'ezcConsoleQuestionDialog'                      => 'ConsoleTools/dialog/question_dialog.php',
    'ezcConsoleMenuDialog'                          => 'ConsoleTools/dialog/menu_dialog.php',
    
    'ezcConsoleDialogOptions'                       => 'ConsoleTools/options/dialog.php',
    'ezcConsoleQuestionDialogOptions'               => 'ConsoleTools/options/question_dialog.php',
    'ezcConsoleMenuDialogOptions'                   => 'ConsoleTools/options/menu_dialog.php',

    'ezcConsoleQuestionDialogCollectionValidator'   => 'ConsoleTools/dialog/validators/question_dialog_collection.php',
    'ezcConsoleQuestionDialogTypeValidator'         => 'ConsoleTools/dialog/validators/question_dialog_type.php',

    'ezcConsoleNoValidDialogResultException'        => 'ConsoleTools/exceptions/no_valid_dialog_result.php',
);

?>
