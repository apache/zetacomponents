<?php
class User
{
    private $signals = null;
    public $useSignals = true;

    private $properties = array( "id" => null, "name"  => null, "nickname" => null );

    public function __construct( $id, $name, $nickname )
    {
        $this->properties["id"] = $id;
        $this->properties["name"] = $name;
        $this->properties["nickname"] = $nickname;

        if ( !$this->useSignals ) 
        {   
            ezcTemplateConfiguration::getInstance()->cacheManager->read("user", $id );
        }
        else
        {
            $this->signals()->emit( "ezcTemplateCacheRead", "user", $id );
        }
    }

    public function signals()
    {
        if ( $this->signals == null ) 
        {
            $this->signals = new ezcSignalCollection( "UserBla" );
        }

        return $this->signals;
    }

    public function __get( $name )
    {
        switch ( $name )
        {
            case "id":
            case "name":
            case "nickname":

                if ( !$this->useSignals ) 
                {   
                    ezcTemplateConfiguration::getInstance()->cacheManager->read("user", $this->properties["id"] );
                }
                else
                {
                    $this->signals()->emit( "ezcTemplateCacheRead", "user", $this->properties["id"] );
                }

                return $this->properties[$name];
        }    

    }

    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case "id":
            case "name":
            case "nickname":

                // Send update signal.
                ezcTemplateConfiguration::getInstance()->cacheManager->update("user", $this->properties["id"] );
                $this->properties["name"] = $value;
                break;
        }    
    }
}



class Fetch implements ezcTemplateCustomFunction
{
    public static function getCustomFunctionDefinition($name)
    {
        switch ($name)
        {
            case "fetch_user_list":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "user_list";
                $def->parameters = array("offset", "limit");
                return $def;

            case "fetch_user":
                $def = new ezcTemplateCustomFunctionDefinition();
                $def->class = __CLASS__;
                $def->method = "user";
                $def->parameters = array("id");
                return $def;
        }

    }
   
    public static function user_list( $offset = 0, $limit = null )
    {
        $db = ezcDbInstance::get();

        $s = $db->createSelectQuery();
        $s->select( "*")->from("user");

        if ( $limit !== null )
        {
            $s->limit( $limit, $offset );
        }

        $statement = $s->prepare();
        $statement->execute();

        $res = $statement->fetchAll();
      
        
        $users = array();

        // Execute only when we are creating the template.
        foreach ( $res as $a )
        {
            $users[] = new User( $a["id"], $a["name"], $a["nickname"] );

            //ezcTemplateConfiguration::getInstance()->cacheManager->read("user", $a["id"] );
        }
        ////////////

        return $users;
    }

    public static function user( $id )
    {
        $db = ezcDbInstance::get();

        $s = $db->createSelectQuery();
        $s->select( "*")->from("user")->where( $s->expr->eq( "id", $id ) );

        $statement = $s->prepare();
        $statement->execute();

        $res = $statement->fetchAll();
      
        // Execute only when we are creating the template.
        foreach ( $res as $a )
        {
            ezcTemplateConfiguration::getInstance()->cacheManager->read("user", $a["id"] );
        }
        ////////////

        return $res[0];
    }
}

?>
