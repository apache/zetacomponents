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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown when the translation file does not exist.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationMissingTranslationFileException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationMissingTranslationFileException.
     *
     * @param string $fileName
     * @return void
     */
    function __construct( $fileName )
    {
        parent::__construct( "The translation file '{$fileName}' does not exist." );
    }
}
?>
