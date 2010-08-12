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
 * Implements the ComplementEmpty translation filter.
 *
 * The filter replaces a missing translated string with its original.
 *
 * @package Translation
 * @version //autogentag//
 * @mainclass
 */
class ezcTranslationComplementEmptyFilter implements ezcTranslationFilter
{
    /**
     * Singleton instance
     * @var ezcTranslationComplementEmptyFilter
     */
    static private $instance = null;

    /**
     * Private constructor to prevent non-singleton use.
     */
    private function __construct()
    {
    }

    /**
     * Returns an instance of the class ezcTranslationComplementEmptyFilter.
     *
     * @return ezcTranslationComplementEmptyFilter Instance of ezcTranslationComplementEmptyFilter
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ) )
        {
            self::$instance = new ezcTranslationComplementEmptyFilter();
        }
        return self::$instance;
    }

    /**
     * Filters the context $context.
     *
     * Applies the fillin filter on the given context. The filter replaces a
     * missing translated string with its original.
     *
     * @param array(ezcTranslationData) $context
     * @return void
     */
    public function runFilter( array $context )
    {
        foreach ( $context as $element )
        {
            if ( $element->status == ezcTranslationData::UNFINISHED )
            {
                $element->translation = $element->original;
            }
        }
    }
}
?>
