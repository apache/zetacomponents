<?php
/**
 * File containing the ezcTemplateFetchCacheInformation class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Checks if the templates uses some sort of caching.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateFetchCacheInformation extends ezcTemplateTstWalker
{
    public $cacheTst = null;

    public $cacheTemplate = false;
    public $cacheKeys = array();
    public $hasTTL = false;


    public function __construct()
    {
        parent::__construct();
    }


    public function visitCacheTstNode( ezcTemplateCacheTstNode $node )
    {
        $this->cacheTemplate = true;
        $this->cacheTst = $node;

        foreach ( $node->keys as $key )
        {
            // XXX cannot translate.
            // Translate the 'old' variableName to the new name.
           // $k = $key->accept($this);
            $this->cacheKeys[] = $key;
        }

        // And translate the ttl.
        if ( $node->ttl != null ) 
        {
            $this->hasTTL = true;
            // XXX cannot translate.
            // $this->programNode->ttl = $type->ttl->accept($this);
        }

        // return new ezcTemplateNopAstNode();
    }

 







}


?>
