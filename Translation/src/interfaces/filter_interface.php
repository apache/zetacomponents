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
 * @package Translation
 */

/**
 * ezcTranslationFilter defines the common interface for all translation filters.
 *
 * Example:
 * @see ezcTranslationFilterBork::runFilter().
 *
 * @package Translation
 * @version //autogentag//
 */
interface ezcTranslationFilter
{
    /**
     * Returns an instance of the class that implements this interface
     *
     * @return ezcTranslationFilter
     */
    public static function getInstance();

    /**
     * Filters the context $context.
     *
     * This static method is called by the Translation Manager whenever a
     * context is requested. The method should only modify the "translated"
     * string and not touch the original string or comment.
     *
     * For a definition of the array format see {@link
     * ezcTranslation::$translationMap}.
     *
     * @param array(ezcTranslationData) $context
     * @return void
     */
    public function runFilter( array $context );
}
?>
