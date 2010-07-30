<?php
/**
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

/**
 * Provides a set of standard filters.
 *
 * This class defines a set of filters that can be used with both with PHP's
 * filter extension, or with the ezcInputForm class as callback filter method.
 *
 * <code>
 * <?php
 * $definition = array(
 *    'special' => array( OPTIONAL, 'callback',
 *                                  array( 'ezcInputFilter', 'urlFilter' ) ),
 * );
 * $form = new ezcInputForm( ezcInputForm::INPUT_GET, $definition );
 * ?>
 * </code>
 *
 * @package UserInput
 * @version //autogentag//
 */
class ezcInputFilter
{
    /**
     * Receives a variable for filtering. The filter function is free to modify
     * the variable and should return the modified variable.
     *
     * @param mixed  $value        The variable's value
     * @param string $characterSet The value's character set
     * @return mixed The modified value of the variable that was passed
     */
    static function urlFilter( $value, $characterSet )
    {
    }
}
?>
