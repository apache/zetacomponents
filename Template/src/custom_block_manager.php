<?php

class ezcTemplateCustomBlockManager
{
    private static $instance = null;

    private $customBlockClasses = array();

    static public function getInstance()
    {
        if ( self::$instance === null)
        {
            self::$instance = new ezcTemplateCustomBlockManager();
        }

        return self::$instance;
    }

    public function reset()
    {
        $this->customBlockClasses = array();
    }

    public function addClass( ezcTemplateCustomBlock $classInstance )
    {
        $name = get_class( $classInstance );
        
        // Check for redeclaration.
        if ( isset( $this->customBlockClasses[ $name ] ) )
        {
            return false;
        }

        $this->customBlockClasses[ $name ] = $classInstance;
        return true;
    }

    public function getDefinition( $name )
    {
        foreach( $this->customBlockClasses as $class )
        {
            $def = $class->getCustomBlockDefinition( $name );

            if( $def instanceof ezcTemplateCustomBlockDefinition )
                return $def;
        }

        return false;
    }
}

?>
