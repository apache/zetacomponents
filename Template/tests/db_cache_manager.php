<?php

class DbCacheManager
{
    protected $keys = array();
    protected $depth = -1;

    public function startCaching($template, $templatePath, $cachePath, $cacheKeys )
    {

        ezcSignalStaticConnections::getInstance()->connect( "UserBla", "ezcTemplateCacheRead", array( ezcTemplateConfiguration::getInstance()->cacheManager, "read" ) );

        // INSERT NEW cache.
        $db = ezcDbInstance::get();

        $q = $db->prepare("SELECT id FROM cache_templates WHERE cache = :cache" );
        $q->bindValue( ":cache", $cachePath );
        $q->execute();

        $r = $q->fetchAll();

        if( sizeof( $r ) > 0 )
        {
            foreach( $r as $x )
            {
                $id = $x["id"];

                // Reset the expired IDs.
                $s = $db->prepare( "UPDATE cache_templates SET expired=0 WHERE id = :id" );
                $s->bindValue( ":id", $x["id"] );
                $s->execute();
            }
        }
        else
        {
            $q = $db->prepare("INSERT INTO cache_templates VALUES( '', :cache, '', 0)" );
            $q->bindValue( ":cache", $cachePath );
            $q->execute();
            $id = $db->lastInsertId();


            // Insert your own template in the value table.
            $q = $db->prepare("REPLACE INTO cache_values VALUES(:id, :name, :value)" ); 
            $q->bindValue( ":id", $id );
            $q->bindValue( ":name", "include" );
            $q->bindValue( ":value", $templatePath );
            $q->execute();

        }

        $this->depth++;
        array_push( $this->keys, array( "cache_path" => $cachePath, "template_id" => $id));
    }

    public function stopCaching()
    {
        ezcSignalStaticConnections::getInstance()->disconnect( "UserBla", "ezcTemplateCacheRead", array( ezcTemplateConfiguration::getInstance()->cacheManager, "read" ) );

        $this->depth--;
        array_pop( $this->keys);
    }

    public function isValid( $template, $templateName, $cacheName )
    {
        $db = ezcDbInstance::get();
        $q = $db->prepare("SELECT expired FROM cache_templates WHERE cache LIKE :cache" );
        $q->bindValue( ":cache", $cacheName );
        $q->execute();

        $rows = $q->fetchAll();

        if( count( $rows) === 0 ) return false;

        // SLOW!
        foreach( $rows as $r )
        {
            if( $r["expired"] == 1 ) return false;
        }  

        $q = $db->prepare("SELECT id FROM cache_templates WHERE cache = :cache" );
        $q->bindValue( ":cache", $cacheName );
        $q->execute();
        $r = $q->fetchAll();


        $q = $db->prepare( "SELECT * FROM cache_values WHERE name = 'include' AND template_id = :id");
        $q->bindValue( ":id", $r[0]["id"] );
        $q->execute();

        $rows = $q->fetchAll();
        foreach( $rows as $r )
        {
            if( filemtime( $r["value"] ) > filemtime( $cacheName ) )
            {
                return false;
            }
        }

        return true;
    }

    public function isCached( $templateName )
    {
        $db = ezcDbInstance::get();
        $q = $db->prepare("SELECT expired FROM cache_templates WHERE cache LIKE :cache" );
        $q->bindValue( ":cache", $cacheName );
        $q->execute();
    }


    public function update($name, $value)
    {

        $db = ezcDbInstance::get();
        $s = $db->prepare( "UPDATE cache_templates, cache_values SET cache_templates.expired=1 WHERE cache_templates.id = cache_values.template_id AND cache_values.name = :name AND cache_values.value = :value" );
        $s->bindValue( ":name", $name );
        $s->bindValue( ":value", $value );
        $s->execute();

 
    }

    public function read( $name, $value )
    {

        // We don't care about reading of non-cached files.
        if( $this->depth < 0 ) return;


        // From user_list, when cache is created. 

        $db = ezcDbInstance::get();
        $s = $db->prepare( "REPLACE INTO cache_values VALUES ( :id, :name, :value )" );
        $s->bindValue( ":id", $this->keys[$this->depth]["template_id"] );
        $s->bindValue( ":name", $name );
        $s->bindValue( ":value", $value );
        $s->execute();
        
        // Updated the values. If this value changes, the template should be renewed.
    }


    public function includeTemplate( $template, $template_path )
    {
        if( $this->depth >= 0 )
        {
        //    echo ("DEPTH!");
            $db = ezcDbInstance::get();
            $id = $this->keys[ $this->depth ]["template_id"];

            // Insert your parent template in the value table.
            $q = $db->prepare("REPLACE INTO cache_values VALUES(:id, :name, :value)" ); 
            $q->bindValue( ":id", $id );
            $q->bindValue( ":name", "include" );
            $q->bindValue( ":value", $template_path );
            $q->execute();
        }
    }

}

?>
