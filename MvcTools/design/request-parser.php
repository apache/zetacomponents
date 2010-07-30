<?php
/**
 * Interface defining the request parser classes.
 *
 * The request parser is the only layer that should directly access the request
 * variables, in order to instanciate an ezcMvcRequest. The instance of ezcMvcRequest
 * will be used by the router and the router manager, the controller, the view handler
 * and the view manager.
 * The created ezcMvcRequest should handle filtering the request variables, but allows
 * getting the raw value of a variable as well.
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
 * @package MvcTools
 * @version //autogen//
 * @mainclass
 */
interface ezcMvcRequestParser
{  
    /**
     * Parses the request and creates  request object.
     *
     * @return ezcMvcRequest
     */
    public function createRequest();
}
?>
