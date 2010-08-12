<?php
/**
 * File containing the ezcTemplateTranslationProvider class
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
 * @package TemplateTranslationTiein
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcTemplateTranslationProvider provides functions that are called from the
 * template compiler to either translate strings, or convert them into code.
 *
 * @package TemplateTranslationTiein
 * @mainclass
 * @version //autogen//
 */
class ezcTemplateTranslationProvider
{
    /**
     * Translates the string $string from the context $context with $arguments as variables.
     *
     * This static method is called whenever a template directly needs a
     * translated string with the variables substituted.
     *
     * @param string $string
     * @param string $context
     * @param array(string=>mixed) $arguments
     * @return string
     */
    static public function translate( $string, $context, $arguments )
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ctxt = $ttc->manager->getContext( $ttc->locale, $context );
        $translation = $ctxt->getTranslation( $string, $arguments );
        return $translation;
    }

    /**
     * Compiles the string $string from the context $context with $arguments as variables into executable code.
     *
     * This static method translates a string, but inserts special code as
     * replacements for the variables.
     *
     * @param string $string
     * @param string $context
     * @param array(string=>mixed) $arguments
     * @return string
     */
    static public function compile( $string, $context, $arguments )
    {
        $ttc = ezcTemplateTranslationConfiguration::getInstance();
        $ctxt = $ttc->manager->getContext( $ttc->locale, $context );
        $translation = $ctxt->compileTranslation( $string, $arguments );
        return $translation;
    }
}
?>
