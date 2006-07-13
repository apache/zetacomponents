<?php

class ezcTemplateCustomFunctionManager
{
    private static $instance = null;

    private $customFunctionClasses = array();

    static public function getInstance()
    {
        if ( self::$instance === null)
        {
            self::$instance = new ezcTemplateCustomFunctionManager();
        }

        return self::$instance;
    }

    public function reset()
    {
        $this->customBlockClasses = array();
    }

    public function addClass( ezcTemplateCustomFunction $classInstance )
    {
        $name = get_class( $classInstance );
        
        // Check for redeclaration.
        if ( isset( $this->customFunctionClasses[ $name ] ) )
        {
            return false;
        }

        $this->customFunctionClasses[ $name ] = $classInstance;
        return true;
    }

    public function getDefinition( $name )
    {
 
        foreach( $this->customFunctionClasses as $class )
        {
           $def = $class->getCustomFunctionDefinition( $name );

            if( $def instanceof ezcTemplateCustomFunctionDefinition )
                return $def;
        }

        return false;
    }
}

?>
