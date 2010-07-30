<?php
/**
 * Autoloader definition for the UserInput component.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package UserInput
 */

return array(
    'ezcInputFormException'                   => 'UserInput/exceptions/exception.php',
    'ezcInputFormFieldNotFoundException'      => 'UserInput/exceptions/field_not_found.php',
    'ezcInputFormInvalidDefinitionException'  => 'UserInput/exceptions/invalid_definition.php',
    'ezcInputFormNoValidDataException'        => 'UserInput/exceptions/no_valid_data.php',
    'ezcInputFormUnknownFieldException'       => 'UserInput/exceptions/unknown_field.php',
    'ezcInputFormValidDataAvailableException' => 'UserInput/exceptions/valid_data_available.php',
    'ezcInputFormVariableMissingException'    => 'UserInput/exceptions/input_variable_missing.php',
    'ezcInputFormWrongInputSourceException'   => 'UserInput/exceptions/wrong_input_source.php',
    'ezcInputFilter'                          => 'UserInput/input_filter.php',
    'ezcInputForm'                            => 'UserInput/input_form.php',
    'ezcInputFormDefinitionElement'           => 'UserInput/structs/definition_element.php',
);
?>
