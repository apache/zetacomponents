<?php
/**
 * File containing the ezcTemplateBodyAstNode class
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
 * Represents a body consisting of statements.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateBodyAstNode extends ezcTemplateAstNode
{
    /**
     * Array of statements which make up the body.
     * @var array(ezcTemplateStatementAstNode)
     */
    public $statements;

    /**
     * Initialize with function name code and optional arguments
     *
     * @param array(ezcTemplateStatementAstNode) $statements
     */
    public function __construct( Array $statements = null )
    {
        parent::__construct();
        $this->statements = array();

        if ( $statements !== null )
        {
            foreach ( $statements as $statement )
            {
                if ( !$statement instanceof ezcTemplateStatementAstNode )
                {
                    throw new ezcTemplateInternalException( "Body code element can only use objects of instance ezcTemplateStatementAstNode as statements" );
                }
            }
            $this->statements = $statements;
        }
    }

    /**
     * Appends the statement to the current list of statements.
     *
     * @param ezcTemplateStatementAstNode $statement Statement object to append.
     */
    public function appendStatement( ezcTemplateStatementAstNode $statement )
    {
        $this->statements[] = $statement;
    }

    /**
     * Returns the last statement object from the body.
     * If there are no statements in the body it returns null.
     *
     * @return ezcTemplateStatementAstNode
     */
    public function getLastStatement()
    {
        $count = count( $this->statements );
        if ( $count === 0 )
        {
            return null;
        }
        return $this->statements[$count - 1];
    }
}
?>
