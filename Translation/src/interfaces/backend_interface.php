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
 * Interface for Translation backends.
 *
 * This interface describes the methods that a Translation backend should
 * implement.
 *
 * For an example see {@link ezcTranslationTsBackend}.
 *
 * @package Translation
 * @version //autogentag//
 */
interface ezcTranslationBackend
{
    /**
     * Sets the backend specific $configurationData.
     *
     * $configurationData should be an implementation of ezcBaseOptions (or, for
     * sake of backwards compatibility an associative array). See 
     * {@link ezcTranslationTsBackend} for an example implementation.
     *
     * Each implementor must document the options that it accepts and throw an
     * {@link ezcBaseConfigException} with the
     * {@link ezcBaseConfigException::UNKNOWN_CONFIG_SETTING} type if an option
     * is not supported.
     *
     * @param mixed $configurationData
     * @return void
     */
    public function setOptions( $configurationData );

    /**
     * Returns an array with translation data for the context $context and the locale
     * $locale.
     *
     * This method returns an array describing the map used for translation of text.
     * For the format see {@link ezcTranslation::$translationMap}.
     *
     * @throws TranslationException when a context is not available.
     * @param string $locale
     * @param string $context
     * @return array
     */
    public function getContext( $locale, $context );
}
?>
