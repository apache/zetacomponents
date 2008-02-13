<?php
class DbCacheManager implements ezcTemplateCacheManager
{
    protected $keys = array();
    protected $depth = -1;

    public function startCaching($template, $templatePath, $cachePath, $cacheKeys )
    {
        ezcSignalStaticConnections::getInstance()->connect( "UserBla", "ezcTemplateCacheRead", array( ezcTemplateConfiguration::getInstance()->cacheManager, "register" ) );

        // INSERT NEW cache.
        $db = ezcDbInstance::get();

        $q = $db->createSelectQuery();
        $s = $q->select( 'id' )
               ->from( $db->quoteIdentifier( 'cache_templates' ) )
               ->where( $q->expr->eq( $db->quoteIdentifier( 'cache' ), $q->bindValue( $cachePath ) ) )
               ->prepare();
        $s->execute();

        $r = $s->fetchAll(); // Strange if there is more than one result.

        if ( sizeof( $r ) > 0 )
        {
            foreach ( $r as $x )
            {
                $id = $r[0]["id"];

                // Reset the expired IDs.
                $q = $db->createUpdateQuery();
                $s = $q->update( $db->quoteIdentifier( 'cache_templates' ) )
                       ->set( $db->quoteIdentifier( 'expired' ), 0 )
                       ->where( $q->expr->eq( $db->quoteIdentifier( 'id' ), $q->bindValue( $r[0]['id'] ) ) )
                       ->prepare();
                $s->execute();
            }
        }
        else
        {
            $q = $db->createInsertQuery();
            $s = $q->insertInto( $db->quoteIdentifier( 'cache_templates' ) )
                   ->set( $db->quoteIdentifier( 'cache' ), $q->bindValue( $cachePath ) )
                   ->set( $db->quoteIdentifier( 'expired' ), $q->bindValue( 0 ) )
                   ->prepare();
            $s->execute();
            $id = $db->lastInsertId( 'id_seq' );

            // Insert your own template in the value table.
            $q = $db->prepare("INSERT INTO cache_values(template_id, name, value) VALUES(:id, :name, :value)" ); 
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
        ezcSignalStaticConnections::getInstance()->disconnect( "UserBla", "ezcTemplateCacheRead", array( ezcTemplateConfiguration::getInstance()->cacheManager, "register" ) );

        $this->depth--;
        array_pop( $this->keys);
    }

    public function isValid( $template, $templateName, $cacheName )
    {
        $db = ezcDbInstance::get();

        $q = $db->prepare("SELECT id, expired FROM cache_templates WHERE cache = :cache" );
        $q->bindValue( ":cache", $cacheName );
        $q->execute();

        $r = $q->fetchAll(); // Expect 0 or 1 result

        if ( count($r) == 0 || $r[0]["expired"] == 1 )
        {
            return false;
        }

        
        $q = $db->prepare( "SELECT * FROM cache_values WHERE name = 'include' AND template_id = :id");
        $q->bindValue( ":id", $r[0]["id"] );
        $q->execute();

        $rows = $q->fetchAll();
        foreach ( $rows as $r )
        {
            if ( !file_exists( $r["value"] ) )
            {
                print("The file ". $r["value"] ." doesn't exist\n\n");
            }
            else
            {
                if ( filemtime( $r["value"] ) > filemtime( $cacheName ) )
                {
                    return false;
                }
            }
        }

        return true;
    }


    public function update($name, $value)
    {
        $db = ezcDbInstance::get();

        $q = $db->createUpdateQuery();
        $sq = $q->subSelect();
        $sq->select( $db->quoteIdentifier( 'id' ) )
           ->from( $db->quoteIdentifier( 'cache_values' ) )
           ->where( $sq->expr->lAnd(
                 $sq->expr->eq( $db->quoteIdentifier( 'name' ), $sq->bindValue( $name ) ),
                 $sq->expr->eq( $db->quoteIdentifier( 'value' ), $sq->bindValue( $value ) )
             ));

        $q->update( $db->quoteIdentifier( 'cache_templates' ) )
               ->set( $db->quoteIdentifier( 'expired' ), 1  )
               ->where( $q->expr->in( $db->quoteIdentifier( 'id' ), $sq ) );
        $s = $q->prepare();
        $s->execute();
//        $s = $db->prepare( "UPDATE cache_templates, cache_values SET cache_templates.expired=1 WHERE cache_templates.id = cache_values.template_id AND cache_values.name = :name AND cache_values.value = :value" );
//        $s->bindValue( ":name", $name );
//        $s->bindValue( ":value", $value );

 
    }

    public function register( $name, $value )
    {
        $db = ezcDbInstance::get();
        for($i =0; $i < $this->depth; $i++)
        { 
            $s = $db->prepare( "DELETE FROM cache_values WHERE template_id = :id AND name = :name AND value = :value" );
            $s->bindValue( ":id", $this->keys[$i]["template_id"] );
            $s->bindValue( ":name", $name );
            $s->bindValue( ":value", $value );
            $s->execute();

            // From user_list, when cache is created. 
            $s = $db->prepare( "INSERT INTO cache_values(template_id, name, value) VALUES ( :id, :name, :value )" );
            $s->bindValue( ":id", $this->keys[$i]["template_id"] );
            $s->bindValue( ":name", $name );
            $s->bindValue( ":value", $value );
            $s->execute();
        }
        
        // Updated the values. If this value changes, the template should be renewed.
    }


    public function includeTemplate( $template, $template_path )
    {
        if ( $this->depth >= 0 )
        {
            $db = ezcDbInstance::get();
            $id = $this->keys[ $this->depth ]["template_id"];

            // Insert your parent template in the value table.
            $s = $db->prepare( "DELETE FROM cache_values WHERE template_id = :id AND name = :name AND value = :value" );
            $s->bindValue( ":id", $id );
            $s->bindValue( ":name", "include" );
            $s->bindValue( ":value", $template_path );
            $s->execute();

            $q = $db->prepare("INSERT INTO cache_values(template_id, name, value) VALUES(:id, :name, :value)" ); 
            $q->bindValue( ":id", $id );
            $q->bindValue( ":name", "include" );
            $q->bindValue( ":value", $template_path );
            $q->execute();
        }
    }


    public function cleanExpired() 
    {
        $db = ezcDbInstance::get();

        $q = $db->prepare("SELECT * FROM cache_templates WHERE expired = 1" );
        $q->execute();
        $rows = $q->fetchAll();

        foreach ($rows as $r)
        {
            unlink( $r["cache"] );
        }

        $db = ezcDbInstance::get();

        // DELETE FROM cache_values WHERE template_id IN ( SELECT id FROM cache_templates WHERE expired = 1 );
        $q = $db->createDeleteQuery();
        $sq = $q->subSelect();
        $sq->select( 'id' )->from( 'cache_templates' )->where( $sq->expr->eq( $db->quoteIdentifier( 'expired' ), $sq->bindValue( 1 ) ) );
        $q->deleteFrom( $db->quoteIdentifier( 'cache_values' ) )->where( $q->expr->in( $db->quoteIdentifier( 'template_id' ), $sq ) );
        $s = $q->prepare();
        $s->execute();

        $db->exec("DELETE FROM cache_templates WHERE cache_templates.expired = 1");
    }
}

?>
