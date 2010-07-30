<?php
/**
 * File containing the ezcTemplateLocationInterface class
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
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Interface for classes implementing a dynamic template location.
 *
 * An object implementing the ezcTemplateLocationInterface can be used as a substitute
 * for the template source in the ezcTemplate::process() method and inside the template
 * {include} block.
 *
 * Inside a template, a custom function is used to create this location object. The 
 * following template source:
 * <code>
 * Hello word!
 * {include dynloc("my_template.ezt")}
 * </code>
 *
 * With the following custom function definition:
 * <code>
 * class DynLocCF implements ezcTemplateCustomFunction
 * {
 *     public static function getCustomFunctionDefinition( $name )
 *     {
 *          if ( $name === "dynloc" )
 *          {
 *             $def = new ezcTemplateCustomFunctionDefinition();
 *             $def->class = __CLASS__;
 *             $def->method = "dynloc";
 *             $def->sendTemplateObject = true;
 *             return $def;
 *          }
 *          return false;
 *     }
 *
 *     public static function dynloc($templateObj, $name)
 *     {
 *         return new DynamicLocation($templateObj, $name);
 *     }
 * }
 * </code>
 * 
 * The dynloc() method returns a new DynamicLocation object. A 
 * simple implementation of the ezcTemplateLocationInterface is shown below:
 *
 * <code>
 * class DynamicLocation implements ezcTemplateLocationInterface
 * {
 *      protected $templatePath;
 *      protected $templateName;
 *
 *      public function __construct( $templateObj, $templateName)
 *      {
 *          $this->templateName = $templateName;
 *          $this->templatePath = $templateObj->usedConfiguration->templatePath;
 *      }
 *
 *      public function getPath()
 *      {
 *          $loc = $this->templatePath ."/". $this->templateName;
 *          if ( !file_exists( $loc ) )
 *          {
 *              $loc = "/fallback/" . $this->templateName;
 *          } 
 *
 *          return $loc;
 *      }
 * }
 * </code>
 *
 * The template will first try to use the original template. If that template 
 * does not exist, it uses the fallback template.
 *
 * @package Template
 * @version //autogen//
 */
interface ezcTemplateLocation
{
    /**
     * Implement this method to return the path to the template source.
     * The original template name is set with any other method.
     *
     * @return string Path to the template source.
     */
	public function getPath();
}
?>
