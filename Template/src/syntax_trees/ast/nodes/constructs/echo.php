<?php
/**
 * File containing the ezcTemplateEchoAstNode class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */
/**
 * Represents an echo construct.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateEchoAstNode extends ezcTemplateStatementAstNode
{
    /**
     * List of code elements which are going to be evaluated and output.
     * @var array(ezcTemplateAstNode)
     */
    public $outputList;

    /**
     * Constructs a new ezcTemplateEchoAstNode
     *
     * @param array(ezcTemplateAstNode) $outputList
     */
    public function __construct( Array $outputList = null )
    {
        parent::__construct();
        $this->outputList = array();

        if ( $outputList !== null )
        {
            foreach ( $outputList as $output )
            {
                $this->appendOutput( $output );
            }
        }
    }

    /**
     * Append a new output element to the current list.
     *
     * @param ezcTemplateAstNode $output
     * @return void
     */
    public function appendOutput( ezcTemplateAstNode $output )
    {
        $this->outputList[] = $output;
    }

    /**
     * Returns the current list of output elements.
     * @return array(ezcTemplateAstNode)
     */
    public function getOutputList()
    {
        return $this->outputList;
    }

    /**
     * Validates the output parameters against their constraints.
     *
     * @throws ezcTemplateInternalException if the constraints are not met.
     * @return void
     */
    public function validate()
    {
        if ( count( $this->outputList ) == 0 )
        {
            throw new ezcTemplateInternalException( "Too few output parameters for class <" . get_class( $this ) . ">, needs at least 1 but got 0." );
        }
    }
}
?>
