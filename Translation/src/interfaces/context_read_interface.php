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
 * Common interface for all context readers.
 *
 * This interface specifies the methods that a backend should implement if it
 * wants to act as a general purpose translation context reader. It extends on
 * the built-in Iterator interface.
 *
 * Example (see {@link ezcTranslationTsBackend} for a more elaborate example):
 * <code>
 * <?php
 *     $r = new ezcTranslationTsBackend( 'usr/share/translations' );
 *     $r->setOptions( array( 'format' => 'translation-[LOCALE].xml' ) );
 *     $r->initReader( 'nl_NL' );
 *     $r->next();
 *     while ( $r->valid() )
 *     {
 *         $ctxt = $r->current();
 *         $r->next();
 *     }
 *     $r->deinitReader();
 * ?>
 * </code>
 *
 * @package Translation
 * @version //autogentag//
 */
interface ezcTranslationContextRead extends Iterator
{
    /**
     * Initializes the reader to read from the locale $locale.
     *
     * Before starting to request context through the reader, you should call
     * this method to initialize it.
     *
     * @param  string $locale
     * @throws TranslationException when the path of the translation and the
     *                              fileformat of the translation are not set before
     *                              this method is called.
     * @return void
     */
    public function initReader( $locale );

    /**
     * Deinitializes the reader.
     *
     * This method should be called after the haveMore() method returns false
     * to cleanup resources.
     *
     * @throws TranslationException when the reader is not initialized with
     *                              initReader().
     * @return void
     */
    public function deinitReader();
}
?>
