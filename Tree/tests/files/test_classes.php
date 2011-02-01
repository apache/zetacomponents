<?php
/**
 * File containing test code for the Tree component.
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
 * @package Tree
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

class TestTranslateDataStore extends ezcTreeMemoryDataStore implements ezcTreeDataStore
{
    public function fetchDataForNode( ezcTreeNode $node )
    {
        if ( $node->id == 'vuur' )
        {
            $node->data = array( 'en' => 'fire', 'de' => 'feuer', 'no' => 'fyr' );
        }
        if ( $node->id == 'Be' )
        {
            $node->data = 'Beryllium';
        }
        if ( $node->id == 'Al' )
        {
            $node->data = 'Aluminium';
        }

        switch( $node->id )
        {
            case 'Aries':  $node->data = '♈'; break;
            case 'Taurus': $node->data = '♉'; break;
            case 'Gemini': $node->data = '♊'; break;
            case 'Cancer': $node->data = '♋'; break;
        }
        $node->dataFetched = true;
    }

    public function fetchDataForNodes( ezcTreeNodeList $nodeList )
    {
        foreach( $nodeList->nodes as $node )
        {
            $this->fetchDataForNode( $node );
        }
    }

    public function storeDataForNode( ezcTreeNode $node )
    {
        /* This is a no-op as the data is already in the $node */
    }
}

class TestExtendedTreeNode extends ezcTreeNode
{
}
?>
