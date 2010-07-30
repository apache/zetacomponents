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
 * Common interface for all context writers.
 *
 * This interface specifies the methods that a backend should implement if it
 * wants to act as a general purpose translation context writer.
 *
 * For an example see {@link ezcTranslationCacheBackend}.
 *
 * @package Translation
 * @version //autogentag//
 */
interface ezcTranslationContextWrite
{
    /**
     * Initializes the writer to write from the locale $locale.
     *
     * Before starting to writer contexts to the writer, you should call
     * this method to initialize it.
     *
     * @param string $locale
     * @throws TranslationException when the path of the translation and the
     *                              translation format are not set before this
     *                              method is called.
     * @return void
     */
    public function initWriter( $locale );

    /**
     * Deinitializes the writer
     *
     * This method should be called after the last context was written to
     * cleanup resources.
     *
     * @throws TranslationException when the writer is not initialized with
     *                              initWriter().
     * @return void
     */
    public function deinitWriter();

    /**
     * Stores the context named $context with the data $data.
     *
     * $data must contain the translations data map.
     * This method stores the context that it received to the backend specified
     * storage place.
     *
     * @throws TranslationException when the writer is not initialized with
     *                              initWriter().
     * @param string $context
     * @param array  $data
     * @return void
     */
    public function storeContext( $context, array $data );
}
?>
